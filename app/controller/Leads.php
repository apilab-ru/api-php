<?php

namespace app\controller;

use app\entity\DateDto;
use app\entity\request\StatisticLeadFilter;
use \app\model\Leads as MLeads;
use \app\entity\BaseResponse;

class Leads extends Base {

    /**
     * @SWG\Get(
     *     path="/api/leads",
     *     summary="Список",
     *     operationId="getLeads",
     *     produces={"application/json"},
     *     tags={"lead"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Lead")
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
        return (new MLeads())->getList();
    }

    /**
     * @SWG\Post(
     *     path="/api/leads",
     *     summary="Добавить",
     *     operationId="addLead",
     *     produces={"application/json"},
     *     tags={"lead"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lead"),
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
    public function add($param)
    {
        return (new MLeads())->add($param);
    }

    /**
     * @SWG\Patch(
     *     path="/api/leads/{id}",
     *     summary="Редактировать",
     *     operationId="editLead",
     *     produces={"application/json"},
     *     tags={"lead"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Lead"),
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
     *         response="404", description="Не нейдено",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function edit($param, $args)
    {
        (new MLeads())->update($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/leads/{id}",
     *     summary="Удалить",
     *     operationId="deleteLead",
     *     produces={"application/json"},
     *     tags={"lead"},
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
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Не найдено",
     *     )
     * )
     */
    public function delete($param, $args)
    {
        (new MLeads())->delete((int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/leads/statistic/{from}/{to}/{mode}",
     *     summary="Список",
     *     operationId="getLeadsStatistic",
     *     produces={"application/json"},
     *     tags={"lead"},
     *     @SWG\Parameter(
     *         name="mode",
     *         in="path",
     *         description="mode",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="from",
     *         in="path",
     *         description="from",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="to",
     *         in="path",
     *         description="to",
     *         required=true,
     *         type="string",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Lead")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStatisticByDate($param, $args)
    {
    	$statistic = new StatisticLeadFilter($param);
        return (new MLeads())->getStatisticByDate($statistic);
    }

	/**
	 * @SWG\Get(
	 *     path="/api/leads/statuses",
	 *     summary="Список статусов лидов",
	 *     operationId="getLeadsStatuses",
	 *     produces={"application/json"},
	 *     tags={"lead"},
	 *     @SWG\Response(
	 *         response=200,
	 *         description="successful operation",
	 *         @SWG\Schema(
	 *             type="array",
	 *             @SWG\Items(ref="#/definitions/LeadStatus")
	 *         ),
	 *     ),
	 *     @SWG\Response(
	 *         response="403",
	 *         description="Нет доступа для выполнения операции",
	 *     )
	 * )
	 */
    public function getStatusList()
	{
		return (new MLeads())->getStatusList();
	}

	/**
	 * @SWG\Delete(
	 *     path="/api/leads/statuses/{id}",
	 *     summary="Удалить",
	 *     operationId="deleteLeadStatus",
	 *     produces={"application/json"},
	 *     tags={"lead"},
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
	 *     @SWG\Response(response=403, description="Нет доступа"),
	 *     @SWG\Response(
	 *         response="404", description="Не найдено",
	 *     )
	 * )
	 */
	public function deleteStatus($param, $args)
	{
		(new MLeads())->deleteStatus((int)$args['id']);
		return new BaseResponse(true);
	}

	/**
	 * @SWG\Patch(
	 *     path="/api/leads/statuses/{id}",
	 *     summary="Редактировать",
	 *     operationId="editLead",
	 *     produces={"application/json"},
	 *     tags={"lead"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/LeadStatus"),
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
	 *         response="404", description="Не нейдено",
	 *         @SWG\Schema(ref="#/definitions/BaseResponse")
	 *     )
	 * )
	 */
	public function editStatus($param, $args)
	{
		(new MLeads())->updateStatus($param, (int)$args['id']);
		return new BaseResponse(true);
	}

	/**
	 * @SWG\Post(
	 *     path="/api/leads/statuses",
	 *     summary="Добавить",
	 *     operationId="addLead",
	 *     produces={"application/json"},
	 *     tags={"lead"},
	 *     @SWG\Parameter(
	 *         name="body",
	 *         in="body",
	 *         required=true,
	 *         @SWG\Schema(ref="#/definitions/LeadStatus"),
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
	public function addStatus($param)
	{
		return (new MLeads())->addStatus($param);
	}

}