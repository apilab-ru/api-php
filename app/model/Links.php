<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Link;
use app\entity\LinkDetail;

class Links extends Base
{

    public function getLinksForCourse(int $courseId): ?array
    {
        $data = $this->select("select * from links where entity='course' && entity_id=?d", $courseId);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Link($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function addLinksForStudent(int $studentId, array $links): ?bool
    {
        $this->db->query("delete from links where entity='student' && entity_id=?d", $studentId);
        foreach($links as $data) {
            $link = new LinkDetail($data, true);
            $link->entity = 'student';
            $link->entity_id = $studentId;
            $this->db->insert('links', $link->serializeToBd());
        }
        return true;
    }

    public function addLinksForCourse(int $courseId, array $links): ?bool
    {
        $this->db->query("delete from links where entity='course' && entity_id=?d", $courseId);
        foreach($links as $data) {
            $link = new LinkDetail($data, true);
            $link->entity = 'course';
            $link->entity_id = $courseId;
            $this->db->insert('links', $link->serializeToBd());
        }
        return true;
    }

    public function getLinksForStudentCourse(int $studentId): array
    {
        $data = $this->select("select l.name, l.link, l.id from links as l 
          left join students_courses as sc on sc.student_id = ?d
          left join courses as c on c.id = sc.course_id
          where entity='course' && entity_id=c.id", $studentId);

        $list = [];
        foreach($data as $item) {
            $list[] = new Link($item);
        }
        return $list;
    }

    public function getLinksForStudent(int $studentId): array
    {
        $data = $this->select("select l.name, l.link, l.id from links as l
          where entity='student' && entity_id=?d", $studentId);

        $list = [];
        foreach ($data as $item) {
            $list[] = new Link($item);
        }
        return $list;
    }
}