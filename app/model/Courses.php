<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Course;

class Courses extends Base
{
    public function getList(): ?array
    {
        $data = $this->db->select("select * from courses");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Course($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getCourse(int $id): Course {
        $data = $this->db->selectRow("select * from courses where id=?d", $id);
        return new Course($data);
    }

    public function add(array $data)
    {
        $item = (new Course($data, true))->serializeToBd();
        return $this->updateObject('courses', $item);
    }

    public function update(array $data, int $id)
    {
        $item = (new Course($data, true));
        return $this->updateObject('courses', $item->serializeToBd(), $id);
    }

    public function delete(int $id)
    {
        $this->db->query("delete from links where entity='course' && entity_id=?d", $id);
        return $this->deleteObject('courses', $id);
    }

}