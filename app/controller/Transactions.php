<?php

namespace app\controller;

use app\entity\BalanceResponse;
use app\entity\BaseResponse;
use app\model\Transactions as MTransactions;

class Transactions extends Base
{

    /**
     * @SWG\Get(
     *     path="/api/transactions/student/{studentId}",
     *     summary="Список финансовых операций ученика",
     *     operationId="getTransactionsStudent",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Transaction")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getListStudent($param, $args)
    {
        return (new MTransactions())->getList('student', (integer)$args['id']);
    }

    /**
     * @SWG\Post(
     *     path="/api/transactions/student/{studentId}",
     *     summary="Добавить",
     *     operationId="addTransactionStudent",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Transaction"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа",
     *     )
     * )
     */
    public function addTransactionStudent($param, $args)
    {
        return (new MTransactions())->addTransaction('student', (integer)$args['id'], $param);
    }

    /**
     * @SWG\Post(
     *     path="/api/transactions/user/{studentId}",
     *     summary="Добавить",
     *     operationId="addTransactionUser",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Transaction"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа",
     *     )
     * )
     */
    public function addTransactionUser($param, $args)
    {
        return (new MTransactions())->addTransaction('user', (integer)$args['id'], $param);
    }

    /**
     * @SWG\Patch(
     *     path="/api/transactions/{id}",
     *     summary="Редактировать",
     *     operationId="editTransaction",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="transaction ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Transaction"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editTransaction($param, $args)
    {
        (new MTransactions())->updateTransaction($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/transactions/{id}",
     *     summary="Удалить операцию",
     *     operationId="deleteTransaction",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID транзакции",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Язык не найден",
     *     )
     * )
     */
    public function deleteTransaction($param, $args)
    {
        (new MTransactions())->deleteTransaction((int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/transactions/corporate-user/{id}",
     *     summary="Список финансовых корпоративного клиента",
     *     operationId="getTransactionsCorporateUser",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Transaction")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTransactionsCorporateUser($param, $args)
    {
        return (new MTransactions())->getTransactionsCorporateUser((integer)$args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/transactions/corporate-user/{id}/balance",
     *     summary="Баланс корпоративного клиента",
     *     operationId="getBalanceCorporateUser",
     *     produces={"application/json"},
     *     tags={"transaction"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *          @SWG\Schema(ref="#/definitions/BalanceResponse"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getBalanceCorporateUser($param, $args)
    {
        return new BalanceResponse(
            (new MTransactions())->getBalanceCorporateUser((integer)$args['id'])
        );
    }

}