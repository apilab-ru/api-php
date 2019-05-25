<?php

namespace app\controller;

use app\model\Docs as MDocs;

class Docs extends Base
{

    /**
     * @SWG\Get(
     *     path="/api/docs/student-contract/{studentId}/{groupId}",
     *     summary="Контракт ученика",
     *     operationId="getAttendanceStatuses",
     *     produces={"application/json"},
     *     tags={"docs"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="groupId",
     *         in="path",
     *         description="ID Группы",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentContract($param, $args)
    {
        $data = (new MDocs)->getDataStudentContract((int) $args['studentId'], (int) $args['groupId']);
        foreach ($data as $key5566 => $it5566) {
            $$key5566 = $it5566;
        }
        include dirname(__FILE__) . '/../docs/contract.php';
        die();
    }

}