<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Category;

class Categories extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select * from categories");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Category($item);
            }
            return $list;
        } else {
            return [];
        }
    }

}