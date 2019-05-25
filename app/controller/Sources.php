<?php

namespace app\controller;

use app\entity\BaseResponse;
use \app\model\Sources as MSources;

class Sources extends Base
{

	/**
	 * @SWG\Get(
	 *     path="/api/sources",
	 *     summary="Список источников",
	 *     operationId="getSources",
	 *     produces={"application/json"},
	 *     tags={"source"},
	 *     @SWG\Response(
	 *         response=200,
	 *         description="successful operation",
	 *         @SWG\Schema(
	 *             type="array",
	 *             @SWG\Items(ref="#/definitions/Source")
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
		return (new MSources)->getList();
	}

	/**
	 * @SWG\Delete(
	 *     path="/api/sources/{id}",
	 *     summary="Удалить источник",
	 *     operationId="deleteSource",
	 *     produces={"application/json"},
	 *     tags={"source"},
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
	 *         @SWG\Schema(ref="#/definitions/BaseResponse"),
	 *     ),
	 * )
	 */
	public function deleteSource($param, $args)
	{
		(new MSources)->deleteSource((int) $args['id']);
		return new BaseResponse(true);
	}

	/**
	 * @SWG\Post(
	 *     path="/api/sources",
	 *     summary="Добавить источник",
	 *     operationId="addSource",
	 *     produces={"application/json"},
	 *     tags={"source"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/Source"),
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="successful operation",
	 *         @SWG\Schema(ref="#/definitions/BaseResponse")
	 *     ),
	 * )
	 */
	public function addSource($param)
	{
		$sourceId = (new MSources())->addSource($param);
		return new BaseResponse(true, null, $sourceId);
	}

	/**
	 * @SWG\Patch(
	 *     path="/api/sources/{id}",
	 *     summary="Редактировать источник",
	 *     operationId="editSource",
	 *     produces={"application/json"},
	 *     tags={"source"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/Source"),
	 *     ),
	 *     @SWG\Parameter(
	 *         name="id",
	 *         in="path",
	 *         description="ID Источника",
	 *         required=true,
	 *         type="integer",
	 *         collectionFormat="multi"
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="successful operation",
	 *         @SWG\Schema(ref="#/definitions/BaseResponse")
	 *     ),
	 * )
	 */
	public function editSource($param, $args)
	{
		(new MSources())->updateSource($param, (int)$args['id']);
		return new BaseResponse(true);
	}

}