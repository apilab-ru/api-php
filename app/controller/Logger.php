<?php

namespace app\controller;

class Logger extends Base{

    /**
     * @SWG\Get(
     *     path="/api/log",
     *     summary="Log",
     *     description="Log",
     *     operationId="log",
     *     produces={"application/json"},
     *     tags={"log"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     * )
     */
    public function log()
    {
        $list = (new \app\model\log())->getList();
        
        pr($list);
    }
    
    public function clear()
    {
        (new \app\model\log())->clear();
    }
    
}
