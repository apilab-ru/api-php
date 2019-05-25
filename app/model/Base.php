<?php

namespace app\model;

use \app\entity\DateDto;
use \app\entity\Base as EntityBase;
use \app\App;

class Base
{
    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }

    public function addObject($table, array $send)
	{
		$id = $this->db->insert($table, $send);
		$this->db->checkError();
		return $id;
	}

    public function updateObject($table, array $send, $id = null): ?int
    {
        if ($id) {
            $this->db->update($table, $send, $id);
			$this->db->checkError();
			return $id;
        } else {
            return $this->addObject($table, $send);
        }
    }

    public function deleteObject($table, $id)
    {
        $this->db->query("DELETE from $table where id=?d", $id);
        $this->db->checkError();
        return true;
    }

    public function select()
    {
        $args = func_get_args();
        $res = call_user_func_array([$this->db, 'select'], $args);
        $this->db->checkError();
        return $res;
    }

    public function selectRow()
    {
        $args = func_get_args();
        $res = call_user_func_array([$this->db, 'selectRow'], $args);
        $this->db->checkError();
        return $res;
    }

    public function selectCell()
    {
        $args = func_get_args();
        $res = call_user_func_array([$this->db, 'selectCell'], $args);
        $this->db->checkError();
        return $res;
    }

    public function createLimit(&$page, &$limit)
    {
        $limit = ($limit) ? $limit : 20;
        $page = ($page) ? $page : 1;
        $start = ($page - 1) * $limit;
        return " limit $start,$limit";
    }

    public function createOrder($order, $orderType, $defaultOrder = "id", $defaultOrderType = 'DESC')
    {
        $order = $order ? $order : $defaultOrder;
        $orderType = ($orderType) ? $orderType : $defaultOrderType;
        if ($orderType == 'DESC') {
            $orderType = 'DESC';
        } else {
            $orderType = 'ASC';
        }
        return " order by $order $orderType";
    }

    public function getCount()
    {
        return $this->db->selectCell("SELECT FOUND_ROWS()");
    }

    public function setFilter($base, $param)
    {
        foreach ($param as $key => $item) {
            $base[$key] = $item;
        }
        return $base;
    }

    public function clearForm($form, $aviable)
    {
        foreach ($form as $key => $val) {
            if ($aviable[$key]) {

                if (is_array($aviable[$key])) {
                    if (!in_array($val, $aviable[$key])) {
                        $form[$key] = $aviable[$key][0];
                    }
                } else {
                    switch ($aviable[$key]) {
                        case 'text':
                        case 'string':
                            //$form[$key] = $this->escape_string($val);
                            break;

                        case 'int':
                            $form[$key] = ($val || $val === '0') ? intval($val) : null;
                            break;

                        case 'float':
                            $form[$key] = ($val || $val === '0') ? floatval($val) : null;
                            break;

                        case 'json':
                            if (!is_string($val)) {
                                $form[$key] = json_encode($val, JSON_UNESCAPED_UNICODE);
                            }
                            break;

                        case 'date':
                            $form[$key] = date("Y-m-d", strtotime($val));
                            break;

                        case 'datetime':
                            $form[$key] = date("Y-m-d H:i:s", strtotime($val));
                            break;

                        case 'password':
                            if ($val) {
                                $form[$key] = md5($val);
                            } else {
                                unset($form[$key]);
                            }
                            break;
                    }
                }

            } else {
                unset($form[$key]);
            }
        }
        return $form;
    }

    public function prepareValue($val, $type = 'text')
    {
        switch ($type) {
            case 'price':
            case 'percent':
                return ($val || $val === '0') ? floatval($val) : 'NULL';
                break;

            case 'radio':
                return ($val || $val === '0') ? intval($val) : 'NULL';
                break;

            default:
                return "'" . $this->db->escape($val) . "'";
                break;
        }
    }

    public function updateTree($table, $list)
    {
        foreach ($list as $item) {
            $this->db->query("UPDATE $table SET {parent=?d,} `order`=?d where id=?d",
                (isset($item['parent']) ? $item['parent'] : DBSIMPLE_SKIP),
                $item['order'],
                $item['id']);
        }
        $this->db->checkError();
    }

    public function getNowDto(): DateDto
    {
        return new DateDto([
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d')
        ]);
    }

    public function errorNotFound()
    {
        App::$my->errorNotFound();
    }

    public function mergeObject(EntityBase $old, array $new)
    {
        foreach ($old as $key => $value) {
            if(!isset($new[$key])) {
                $new[$key] = $old->{$key};
            }
        }
        return $new;
    }

    public function insertArray($table, array $rows)
    {
        $sql = "INSERT INTO ?# (?#) VALUES ";
        $add = [];

        foreach ($rows as $row) {
            $add[] = "(?a)";
        }
        $sql .= implode(",", $add);

        $map = [];
        $map[] = $sql;
        $map[] = $table;
        $map[] = array_keys($rows[0]);
        foreach ($rows as $row) {
            $map[] = array_values($row);
        }

        return call_user_func_array([$this->db, 'query'], $map);
    }

    public function log($name, $text)
    {
        return $this->updateObject('log', [
            'name' => $name,
            'log' => print_r($text, true)
        ]);
    }
}