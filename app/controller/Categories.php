<?php

namespace app\controller;

use \app\model\Categories as MCategories;

class Categories extends Base {

    /**
     * @SWG\Get(
     *     path="/api/categories",
     *     summary="Список категорий",
     *     operationId="getCategories",
     *     produces={"application/json"},
     *     tags={"category"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getList()
    {
        return (new MCategories())->getList();
    }

}