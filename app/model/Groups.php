<?php

declare(strict_types=1);

namespace app\model;

use app\App;
use app\entity\DateDto;
use app\entity\Group;
use app\entity\GroupDetail;
use app\entity\GroupStudentStatistic;

class Groups extends Base
{

    public function getList(array $filter = null): ?array
    {
        if ($filter['corporate_manager']) {
            $data = $this->db->select("select DISTINCT g.* 
                from groups as g, students as s, members as m
                where m.student_id = s.id && m.group_id = g.id 
                  && s.corporate_manager = ?d", $filter['corporate_manager']);
        } else {
            $data = $this->db->select("select * from groups");
        }
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Group($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getItem($id): Group
    {
        $data = $this->db->selectRow("select * from groups where id=?d", $id);
        if (!$data) {
            App::$my->errorNotFound();
        } else {
            return new Group($data);
        }
    }

    public function getMembersCount(int $id): int
    {
        return (int)$this->db->selectCell("select count(*) from members where group_id=?d", $id);
    }

    public function addGroup(array $data)
    {
        $group = (new Group($data, true))->serializeToBd();
        return $this->updateObject('groups', $group);
    }

    public function updateGroup(array $data, $id)
    {
        $group = (new Group($data, true))->serializeToBd();
        return $this->updateObject('groups', $group, $id);
    }

    public function updateStatusGroup(int $groupId, $status)
    {
        // TODO обработка enum-ов
        return $this->updateObject('groups', [
            'status' => $status
        ], $groupId);
    }

    public function deleteGroup($id)
    {
        return $this->deleteObject('groups', $id);
    }

    public function getStudents($groupId)
    {
        return $this->db->selectCol("select student_id from members where group_id=?d", $groupId);
    }

    public function deleteStudent($groupId, $studentId)
    {
        return $this->db->query('delete from members where group_id=?d && student_id=?d', $groupId, $studentId);
    }

    public function addStudent($groupId, $studentId)
    {
        return $this->updateObject('members', [
            'student_id' => $studentId,
            'group_id' => $groupId
        ]);
    }

    public function updateStudentGroups(array $groupList, int $studentId)
	{
		$this->db->query('delete from members where student_id = ?d', $studentId);
		foreach ($groupList as $groupId) {
			$this->addStudent($groupId, $studentId);
		}
	}

    public function getGroupsStudent($studentId): array
    {
        $data = $this->db->select("select g.*, 
          (select count(*) from attendance as a,attendance_students as ast 
              where a.group_id = g.id && ast.attendance_id = a.id and ast.student_id=?d && ast.status_id != 0) as attendee_count
          from groups as g, members as m 
          where g.id = m.group_id && m.student_id=?d", $studentId, $studentId);

        $list = [];
        foreach ($data as $item) {
            $list[] = new Group($item);
        }
        return $list;
    }

    public function getGroupsTeacher($teacherId): array
    {
        $data = $this->db->select("select g.*, count(*) as students_count
          from groups as g, members as m
          where g.teacher_id=?d && m.group_id = g.id
          group by g.id", $teacherId);

        $list = [];
        foreach ($data as $item) {
            $list[] = new GroupDetail($item);
        }
        return $list;
    }

    public function getTypeVisitNameGenitive(string $type)
    {
        switch ($type) {
            case 'daytime':
                return 'дневаной';
            case 'evening':
                return 'вечерней';
        }
    }

    public function getStatisticStudents(int $groupId, ?DateDto $dateStart, ?DateDto $dateEnd): array
    {
        $this->log('dates', [
            $dateStart, $dateEnd
        ]);

        if (!$dateStart || !$dateEnd) {
            $dateStart = date('Y-m-01');
            $dateEnd = date('Y-m-d', strtotime('last day of this month'));
        } else {
            $dateStart = $dateStart->serializeToBd();
            $dateEnd = $dateEnd->serializeToBd();
        }

        $this->log('dates tra', [
            $dateStart, $dateEnd
        ]);

        $total = (int)$this->selectCell("SELECT count(*) FROM `attendance` as a
          WHERE group_id=?d && a.date BETWEEN ? AND ?", $groupId, $dateStart, $dateEnd);
        $data = $this->select("SELECT ats.student_id, COUNT(*) as visited_lesson, CEIL(avg(ats.rating)) as rating 
          FROM `attendance` as a
            left join attendance_students as ats on ats.attendance_id = a.id
            left join attendance_status as astatus on astatus.id = ats.status_id 
                WHERE a.group_id = ?d && astatus.visited = 1 && a.date BETWEEN ? AND ?
                  GROUP by ats.student_id", $groupId, $dateStart, $dateEnd);

        $list = [];
        foreach($data as $item) {
            $stat = new GroupStudentStatistic($item);
            $stat->total_lesson = $total;
            $list[] = $stat;
        }
        return $list;
    }
}