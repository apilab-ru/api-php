<?php

declare(strict_types=1);

namespace app\model;

use app\entity\Transaction;

class Transactions extends Base
{

    public function getList($entity, $id): ?array
    {
        $data = $this->db->select("select * from transactions 
            where entity_type =? && entity_id=?d 
            order by date_create DESC", $entity, $id);
        if ($data) {
            $list = [];
            foreach ($data as $item) {
                $list[] = new Transaction($item);
            }
            return $list;
        } else {
            return [];
        }
    }

    public function getTransactionsCorporateUser(int $id): ?array
    {
        $data = $this->select("SELECT * FROM `transactions` 
          WHERE (entity_type='user' && entity_id = ?d) 
            or (entity_type='student' && entity_id 
              in (select id from students where type = 'corporate' && corporate_manager = ?d))
              order by date_create DESC",
            $id, $id);
        $list = [];
        foreach($data as $item) {
            $list[] = new Transaction($item);
        }
        return $list;
    }

    public function getBalanceCorporateUser(int $id): float {
        $sum = $this->selectCell("SELECT 
          SUM(case when t.type = 'deposit' then t.value else t.value * -1 end) as balance 
            FROM `transactions` as t 
              WHERE (entity_type='user' && entity_id = ?d) 
                or (entity_type='student' && entity_id 
                  in (select id from students where type = 'corporate' && corporate_manager = ?d))", $id, $id);
        return (float)$sum;
    }

    public function addTransaction($entity, $id, $data)
    {
        $data['entity_type'] = $entity;
        $data['entity_id'] = $id;
        $transaction = (new Transaction($data, true))->serializeToBd();
        unset($transaction['date_create']);
        return $this->updateObject('transactions', $transaction);
    }

    public function getTransaction($id): Transaction
    {
        $data = $this->db->selectRow("select * from transactions where id=?d", $id);
        if ($data) {
            return new Transaction($data);
        } else {
            $this->errorNotFound();
        }
    }

    public function updateTransaction(array $data, $id)
    {
        $old = $this->getTransaction($id);
        $data = $this->mergeObject($old, $data);
        $transaction = (new Transaction($data, true));
        return $this->updateObject('transactions', $transaction->serializeToBd(), $id);
    }

    public function deleteTransaction($id)
    {
        return $this->deleteObject('transactions', $id);
    }

    public function calcBalance($entity, $id)
    {
        $cell = $this->db->selectCell("SELECT SUM(
            case t.type 
                WHEN 'deposit' then value
                ELSE value * -1 end
            ) FROM `transactions` as t WHERE entity_type=? && entity_id=?d", $entity, $id);
        return $cell ? (integer)$cell : 0;
    }

}