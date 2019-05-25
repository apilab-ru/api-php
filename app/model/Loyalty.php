<?php

declare(strict_types=1);

namespace app\model;

use app\entity\StudentScore;

class Loyalty extends Base
{
    public function getScoresForStudent(int $id): array
    {
        $list = [];
        $data = $this->db->select("select t.id as teacher_id, loyalty 
          from teachers as t
          left join teachers_loyalty as l on l.teacher_id = t.id && l.student_id =?d", $id);

        foreach ($data as $item) {
            $list[] = new StudentScore($item);
        }
        return $list;
    }

    public function updateStudentTeacherScore(int $studentId, $param)
    {
        $score = new StudentScore($param, true);
        $this->db->query('INSERT INTO `teachers_loyalty` (`teacher_id`, `student_id`, `loyalty`) 
          VALUES (?a) ON DUPLICATE KEY UPDATE loyalty=?d',
            [$score->teacher_id, $studentId, $score->loyalty],
            $score->loyalty
        );
    }

}