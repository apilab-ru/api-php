<?php

namespace app\controller;

use \app\model\Langs as MLangs;
use \app\entity\BaseResponse;

class Langs extends Base {

    /**
     * @SWG\Get(
     *     path="/api/langs",
     *     summary="Список языков",
     *     operationId="getLangs",
     *     produces={"application/json"},
     *     tags={"lang"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Lang")
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
        return (new MLangs())->getList();
    }

    /**
     * @SWG\Post(
     *     path="/api/langs",
     *     summary="Добавить язык",
     *     operationId="addLang",
     *     produces={"application/json"},
     *     tags={"lang"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lang"),
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
    public function addLang($param)
    {
        return (new MLangs())->addLang($param);
    }

    /**
     * @SWG\Patch(
     *     path="/api/langs/{id}",
     *     summary="Редактировать язык",
     *     operationId="editStudent",
     *     produces={"application/json"},
     *     tags={"lang"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lang"),
     *     ),
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
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Язык не нейден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editLang($param, $args)
    {
        (new MLangs())->updateLang($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/langs/{id}",
     *     summary="Удалить язык",
     *     operationId="deleteLang",
     *     produces={"application/json"},
     *     tags={"lang"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID языка",
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
    public function deleteLang($param, $args)
    {
        (new MLangs())->deleteLang((int)$args['id']);
        return new BaseResponse(true);
    }


}