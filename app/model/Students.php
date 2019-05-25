<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Student;
use app\model\Groups as MGroups;
use app\App;

class Students extends Base
{
    public function getItem(int $id, array $filter = null): Student
    {
        $corporateManager = (int)$filter['corporate_manager'];
        $data = $this->db->selectRow("select * from students 
          where id=?d { && corporate_manager =?d }", $id, $corporateManager ? $corporateManager : DBSIMPLE_SKIP);
        if (!$data) {
            App::$my->errorNotFound();
        }
        return new Student($data);
    }

    public function getList(array $filter = null): ?array
    {
        $corporateManager = (int)$filter['corporate_manager'];
        $data = $this->db->select("select s.* from students as s
          where 1 = 1 { && corporate_manager =?d }
          order by id DESC", $corporateManager ? $corporateManager : DBSIMPLE_SKIP);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Student($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function addStudent(array $studentData)
    {
        $groups = $studentData['groups'];
        unset($studentData['groups']);

        $student = (new Student($studentData, true))->serializeToBd();
        $studentId = $this->updateObject('students', $student);

        if ($groups) {
            foreach($groups as $group) {
                (new MGroups)->addStudent((int) $group, $studentId);
            }
        }

        return $studentId;
    }

    public function updateStudent(array $studentData, $id)
    {
        $student = (new Student($studentData, true));
        return $this->updateObject('students', $student->serializeToBd(), $id);
    }

    public function deleteStudent($id)
    {
        return $this->deleteObject('students', $id);
    }

    public function getStudentsByList($ids): array
    {
        $data = $this->db->select('select * from students where id in (?a) order by id DESC', $ids);
        $list = [];
        foreach ($data as $it) {
            $list[] = new Student($it);
        }
        return $list;
    }

}