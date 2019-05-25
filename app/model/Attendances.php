<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Attendance;
use app\entity\AttendanceDetail;
use app\entity\AttendanceStatus;
use app\entity\AttendanceStudent;
use app\entity\DateDto;
use app\entity\TimeDto;
use app\entity\response\ResponseLesson;

class Attendances extends Base
{
    public function getListForStudent($studentId): array
    {
        $list = [];
        $data = $this->db->select("
          select a.*, s.status_id, s.rating, s.comment, s.homework_status, (case st.charge 
                WHEN 1 then g.cost
                ELSE 0 end) as cost
            from attendance as a, `groups` as g, attendance_students as s, attendance_status as st
            where s.student_id=?d && s.attendance_id=a.id && s.status_id!=0 && g.id =a.group_id && st.id = s.status_id", $studentId);
        foreach ($data as $item) {
            $list[] = new AttendanceStudent($item);
        }
        return $list;
    }

    public function getListForTeacher(int $teacherId): array
    {
        $list = [];
        $data = $this->db->select("
          select a.* from attendance as a, groups as g 
          where g.teacher_id=?d && a.group_id = g.id
          order by a.date DESC,a.time DESC", $teacherId);
        foreach ($data as $item) {
            $list[] = new Attendance($item);
        }
        return $list;
    }

    public function getStatuses(): array
    {
        $list = [];
        $data = $this->db->select("select * from attendance_status");
        foreach($data as $item) {
            $list[] = new AttendanceStatus($item);
        }
        return $list;
    }

    public function getListForDate($groupId, DateDto $date): array
    {
        $list = [];
        $data = $this->db->select("select *, id as ARRAY_KEY from attendance where group_id=?d && date=?",
            $groupId, $date->serializeToBd());
        if ($data) {
            $students = $this->db->select("select * from attendance_students where attendance_id in (?a)",
                array_keys($data));
        }
        foreach ($data as $item) {
            $attendance = new Attendance($item);
            $myStudents = array_filter($students, function($it) use ($item){
                return $it['attendance_id'] == $item['id'];
            });
            $attendance->students = [];
            foreach($myStudents as $student) {
                $attendance->students[] = new AttendanceDetail($student);
            }
            $list[] = $attendance;
        }
        return $list;
    }

    public function getListForDateTime(int $groupId, DateDto $date, TimeDto $time): ResponseLesson
    {
        $attendance = $data = $this->db->selectRow("select * from attendance where group_id=?d && date=? && time=?",
            $groupId, $date->serializeToBd(), $time->serializeToBd());
        if (!$attendance) {
            return new ResponseLesson();
        }
        $response = new ResponseLesson($attendance);
        $response->list = [];
        $data = $this->db->select("select * from attendance_students where attendance_id=?d", $response->id);
        foreach ($data as $item) {
            $response->list[] = new AttendanceDetail($item);
        }
        return $response;
    }

    public function addAttendanceDetail(int $groupId, DateDto $date, TimeDto $time, AttendanceDetail $attendance)
    {
        $attendanceId = $data = $this->db->selectCell("select id from attendance where group_id=?d && date=? && time=?",
            $groupId, $date->serializeToBd(), $time->serializeToBd());
        if (!$attendanceId) {
            $attendanceId = $this->addAttendance($groupId, $date, $time);
        }
        $attendance->attendance_id = $attendanceId;

        $attendance->id = $this->db->selectCell("select id from attendance_students 
          where student_id=?d && attendance_id=?d", $attendance->student_id, $attendanceId);

        $attendanceStudentId = $this->updateObject('attendance_students', $attendance->serializeToBd(), $attendance->id);

        $this->db->query("DELETE from transactions where attendee_id=?d", $attendanceStudentId);

        $charge = $this->getStatusCharge($groupId, $attendance->status_id);
        if ($charge) {
            (new Transactions())->addTransaction('student', $attendance->student_id, [
                'attendee_id' => $attendanceStudentId,
                'type' => 'payment',
                'value' => $charge,
                'description' => "Оплата занятия"
            ]);
        }
    }

    public function updateLessonAttendee(array $attendeeData)
    {
        $attendee = new Attendance($attendeeData, true);
        if (!$attendee->id) {
            $attendee->id = $this->db->selectCell("select id from attendance where 
              group_id=? && date=? && time=?",
                $attendee->group_id,
                $attendee->date->serializeToBd(),
                $attendee->time->serializeToBd()
            );
        }
        return $this->updateObject('attendance', $attendee->serializeToBd(), $attendee->id);
    }

    public function addAttendance(int $groupId, DateDto $date, TimeDto $time): ?int
    {
        $attendance = new Attendance([
            'group_id' => $groupId,
            'date' => $date,
            'time' => $time
        ], true);
        return $this->updateObject('attendance', $attendance->serializeToBd());
    }

    private function getStatusCharge(int $groupId, int $statusId): ?int
    {
        return (int)$this->db->selectCell("select s.charge * g.cost as cost
                from attendance_status as s, groups as g
                where g.id = ?d && s.id = ?d", $groupId, $statusId);
    }

}