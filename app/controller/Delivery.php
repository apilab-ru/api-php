<?php

namespace app\controller;

use app\entity\BaseResponse;
use app\model\Delivery as MDelivery;

class Delivery extends Base
{

    /**
     * @SWG\Get(
     *     path="/api/delivery/{deliveryId}",
     *     summary="Подробная информация о рассылке",
     *     operationId="getDeliveryDetails",
     *     produces={"application/json"},
     *     tags={"delivery"},
     *     @SWG\Parameter(
     *         name="deliveryId",
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
	 *         @SWG\Schema(ref="#/definitions/DeliveryDetails"),
	 *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getDeliveryDetail($param, $args)
    {
		return (new MDelivery())->loadDelivery((int) $args['id']);
    }

	/**
	 * @SWG\Patch(
	 *     path="/api/delivery/{deliveryId}",
	 *     summary="Редактировать рассылку",
	 *     operationId="updateDelivery",
	 *     produces={"application/json"},
	 *     tags={"delivery"},
	 *     @SWG\Parameter(
	 *         name="deliveryId",
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
	 *         @SWG\Schema(ref="#/definitions/DeliveryDetails"),
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
	public function updateDelivery($param, $args)
	{
		$id = (new MDelivery())->updateDelivery((int) $args['id'], $param);
		return new BaseResponse(true, null, $id);
	}

	/**
	 * @SWG\Patch(
	 *     path="/api/delivery/{deliveryId}/active",
	 *     summary="Редактировать активность",
	 *     operationId="updateDeliveryActive",
	 *     produces={"application/json"},
	 *     tags={"delivery"},
	 *     @SWG\Parameter(
	 *         name="deliveryId",
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
	 *         @SWG\Schema(ref="#/definitions/DeliveryActive"),
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
	public function updateDeliveryActive($param, $args)
	{
		(new MDelivery())->updateDeliveryActive((int) $args['id'], $param);
		return new BaseResponse(true, null);
	}

    /**
     * @SWG\Post(
     *     path="/api/delivery",
     *     summary="Создать рассылку",
     *     operationId="addDelivery",
     *     produces={"application/json"},
     *     tags={"delivery"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/DeliveryDetails"),
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
    public function addDelivery($param)
    {
        $id = (new MDelivery())->addDelivery($param);
        return new BaseResponse(true, null, $id);
    }

	/**
	 * @SWG\Get(
	 *     path="/api/delivery",
	 *     summary="Список рассылок",
	 *     operationId="getListDelivery",
	 *     produces={"application/json"},
	 *     tags={"delivery"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/Delivery"),
	 *     ),
	 *     @SWG\Response(
	 *         response=200,
	 *         description="successful operation",
	 *         @SWG\Schema(
	 *             type="array",
	 *             @SWG\Items(ref="#/definitions/Delivery")
	 *         ),
	 *     ),
	 *     @SWG\Response(
	 *         response="403",
	 *         description="Нет доступа",
	 *     )
	 * )
	 */
	public function getDeliveryList()
	{
		return (new MDelivery())->getList();
	}

	/**
	 * @SWG\Get(
	 *     path="/api/delivery/cron/check",
	 *     summary="Палинирование рассылки",
	 *     operationId="checkDelivery",
	 *     produces={"application/json"},
	 *     tags={"delivery"},
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
	public function checkDelivery()
	{
		(new MDelivery())->checkDelivery();
		return new BaseResponse(true);
	}

	/**
	 * @SWG\Get(
	 *     path="/api/delivery/cron/send",
	 *     summary="Рассылка",
	 *     operationId="sendDelivery",
	 *     produces={"application/json"},
	 *     tags={"delivery"},
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
	public function sendDelivery()
	{
		(new MDelivery())->sendDelivery();
		return new BaseResponse(true);
	}

}