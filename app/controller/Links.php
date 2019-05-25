<?php

namespace app\controller;

use \app\model\Links as MLinks;
use \app\entity\BaseResponse;

class Links extends Base {

    /**
     * @SWG\Get(
     *     path="/api/links/course/{courseId}",
     *     summary="Список ссылок курса",
     *     operationId="getLinksCourse",
     *     produces={"application/json"},
     *     tags={"link"},
     *     @SWG\Parameter(
     *         name="courseId",
     *         in="path",
     *         description="ID Курса",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Link")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getLinksCourse($param, $args)
    {
        return (new MLinks())->getLinksForCourse($args['courseId']);
    }

    // TODO Swagger
    public function addLinksCourse($param, $args)
    {
        (new MLinks())->addLinksForCourse($args['courseId'], $param['links']);
    }

    // TODO Swagger
    public function addLinksStudent($param, $args)
    {
        (new MLinks())->addLinksForStudent($args['studentId'], $param['links']);
    }
}