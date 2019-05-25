<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Source;

class Sources extends Base
{

    public function getList(): ?array
    {
        $data = $this->db->select("select * from sources order by id ASC");
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Source($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function deleteSource($id)
	{
		return $this->deleteObject('sources', $id);
	}

	public function addSource($form)
	{
		return $this->updateObject('sources', $form);
	}

	public function updateSource($form, $id)
	{
		return $this->updateObject('sources', $form, $id);
	}

}