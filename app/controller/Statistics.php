<?php

namespace app\controller;
use app\model\Statistics as MStatistics;

class Statistics extends Base {

    /**
     * @SWG\Get(
     *     path="/api/statistic",
     *     summary="Стиатистика для Dashboard",
     *     operationId="getTotalStatistic",
     *     produces={"application/json"},
     *     tags={"statistic"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Statistic"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getTotalStatistic()
    {
        return (new MStatistics())->getTotalStatistic();
    }
}