<?php

namespace app\controller;

use \app\model\Levels as MLevels;

class Levels extends Base {

    /**
     * @SWG\Get(
     *     path="/api/levels",
     *     summary="Список языков",
     *     operationId="getLevels",
     *     produces={"application/json"},
     *     tags={"level"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Level")
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
        return (new MLevels())->getList();
    }

}