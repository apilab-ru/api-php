<?php

declare(strict_types=1);

namespace app\model;

use app\App;
use app\entity\Lang;

class Langs extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select * from langs");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Lang($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function addLang(array $data)
    {
        $lang = (new Lang($data, true))->serializeToBd();
        return $this->updateObject('langs', $lang);
    }

    public function updateLang(array $data, $id)
    {
        $lang = (new Lang($data, true));
        return $this->updateObject('langs', $lang->serializeToBd(), $id);
    }

    public function deleteLang($id)
    {
        return $this->deleteObject('langs', $id);
    }

    public function getItem($id): Lang
    {
        $data = $this->db->selectRow("select * from langs where id=?d", $id);
        if (!$data) {
            App::$my->errorNotFound();
        } else {
            return new Lang($data);
        }
    }

}