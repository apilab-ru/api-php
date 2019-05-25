<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Lesson;
use app\App;

class Lessons extends Base
{
    public function getListForGroup($id): ?array
    {
        $data = $this->db->select("select * from lessons where group_id=?d", $id);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Lesson($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getListForTeacher(int $id): ?array
    {
        $data = $this->db->select("select l.* from lessons as l, groups as g 
          where g.teacher_id=?d && l.group_id = g.id", $id);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Lesson($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getItem($id): ?Lesson
    {
        $data = $this->db->selectRow("select * from lessons where id=?d", $id);
        if ($data) {
            return new Lesson($data);
        } else {
            App::$my->errorNotFound();
        }
    }

    public function add(array $data, $groupId)
    {
        $data['group_id'] = $groupId;
        $item = (new Lesson($data, true))->serializeToBd();
        return $this->updateObject('lessons', $item);
    }

    public function update(array $data, $id)
    {
        $lang = (new Lesson($data, true));
        return $this->updateObject('lessons', $lang->serializeToBd(), $id);
    }

    public function delete($id)
    {
        return $this->deleteObject('lessons', $id);
    }

}