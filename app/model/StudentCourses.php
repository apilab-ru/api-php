<?php

declare(strict_types=1);

namespace app\model;

use app\entity\StudentCourse;

class StudentCourses extends Base
{

    public function getStudentCourses($studentId): ?array
    {
        $data = $this->db->select("select * from students_courses where student_id=?d", $studentId);
        $list = [];
        foreach($data as $item) {
            $list[] = new StudentCourse($item);
        }
        return $list;
    }

    public function deleteStudentCourse(int $studentId, int $courseId): ?bool {
        $this->db->query("delete from students_courses where student_id=?d && course_id=?d",
            $studentId, $courseId);
        $this->db->checkError();
        return true;
    }

    public function addStudentCourse(int $studentId, int $courseId): int {
        return $this->updateObject('students_courses', [
            'student_id' => $studentId,
            'course_id' => $courseId
        ]);
    }

}