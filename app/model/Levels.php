<?php

declare(strict_types=1);

namespace app\model;

use app\App;
use app\entity\Level;

class Levels extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select * from levels");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Level($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getItem(int $id): Level
    {
        $data = $this->db->selectRow("select * from levels where id=?d", $id);
        if (!$data) {
            App::$my->errorNotFound();
        } else {
            return new Level($data);
        }
    }

}