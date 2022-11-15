<?php

namespace app\controller;

use app\entity\BaseResponse;

class Ping extends Base
{

    /**
     * @SWG\Get(
     *     path="/api/ping",
     *     summary="Ping",
     *     description="Ping-Pong",
     *     operationId="ping",
     *     produces={"application/json"},
     *     tags={"ping"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Требуется авторизация",
     *     )
     * )
     */
    public function ping()
    {
        return new BaseResponse(true);
    }

}
