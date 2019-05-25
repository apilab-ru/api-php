<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Teacher;
use app\entity\TeacherDetail;

class Teachers extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select t.*, avg(l.loyalty) as rate 
          from teachers as t 
          left join teachers_loyalty as l on l.teacher_id = t.id 
          group by t.id");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Teacher($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getTeacherDetail(int $id): TeacherDetail
    {
        $data = $this->db->selectRow("SELECT t.*, 
            GROUP_CONCAT(DISTINCT cat.category_id SEPARATOR ',') as categories,
            GROUP_CONCAT(DISTINCT course.course_id SEPARATOR ',') as courses,
            GROUP_CONCAT(DISTINCT lang.lang_id SEPARATOR ',') as langs
            FROM `teachers` as t
            LEFT JOIN teacher_categories as cat on cat.teacher_id = t.id
            LEFT JOIN teacher_courses as course on course.teacher_id = t.id
            LEFT JOIN teacher_langs as lang on lang.teacher_id = t.id
            WHERE t.id = ?d 
            group by t.id ", $id);

        if($data['categories'])
            $data['categories'] = array_map('intval', explode(",", $data['categories']));

        if($data['courses'])
            $data['courses'] = array_map('intval', explode(",", $data['courses']));

        if($data['langs'])
            $data['langs'] = array_map('intval', explode(",", $data['langs']));

        return new TeacherDetail($data);
    }

    public function addTeacher(array $teacherData)
    {
        $teacher = (new TeacherDetail($teacherData, true))->serializeToBd();
        $id = $this->updateObject('teachers', $teacher);
        $this->addCourses($id, $teacherData['courses']);
        $this->addLangs($id, $teacherData['langs']);
        $this->addCategories($id, $teacherData['categories']);
        return $id;
    }

    public function updateTeacher(array $teacherData, $id)
    {
        $teacher = (new TeacherDetail($teacherData, true))->serializeToBd();
        $this->updateObject('teachers', $teacher, $id);
        $this->addCourses($id, $teacherData['courses']);
        $this->addLangs($id, $teacherData['langs']);
        $this->addCategories($id, $teacherData['categories']);
    }

    public function addCourses(int $teacher, $courses)
    {
        $this->db->query("DELETE FROM `teacher_courses` WHERE teacher_id=?d", $teacher);
        $list = [];
        if($courses) {
            foreach ($courses as $course) {
                $list[] = [
                    'course_id' => $course,
                    'teacher_id' => $teacher
                ];
            }
            $this->insertArray('teacher_courses', $list);
        }
    }

    public function addLangs(int $teacher, $langs)
    {
        $this->db->query("DELETE FROM `teacher_langs` WHERE teacher_id=?d", $teacher);
        $list = [];
        if($langs) {
            foreach ($langs as $lang) {
                $list[] = [
                    'lang_id' => $lang,
                    'teacher_id' => $teacher
                ];
            }
            $this->insertArray('teacher_langs', $list);
        }
    }

    public function addCategories(int $teacher, $categories)
    {
        $this->db->query("DELETE FROM `teacher_categories` WHERE teacher_id=?d", $teacher);
        $list = [];
        if($categories) {
            foreach ($categories as $category) {
                $list[] = [
                    'category_id' => $category,
                    'teacher_id' => $teacher
                ];
            }
            $this->insertArray('teacher_categories', $list);
        }
    }

    public function deleteTeacher(int $id)
    {
        return $this->deleteObject('teachers', $id);
    }

}