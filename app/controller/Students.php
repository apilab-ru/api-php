<?php

namespace app\controller;

use app\entity\BalanceResponse;
use app\entity\StudentManualsResponse;
use \app\model\Students as MStudents;
use \app\entity\BaseResponse;
use \app\model\Groups as MGroups;
use \app\model\Transactions as MTransactions;
use \app\model\Attendances as MAttendances;
use \app\model\Loyalty as MLoyalty;
use \app\model\StudentCourses as MStudentCourses;
use \app\model\Links as MLinks;

class Students extends Base
{
    /**
     * @SWG\Get(
     *     path="/api/students/{id}",
     *     summary="Ученик",
     *     operationId="getStudent",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Student"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudent($param, $args)
    {
        return (new MStudents())->getItem((int)$args['id'], $args);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/balance",
     *     summary="Баланс ученика",
     *     operationId="getStudentBalance",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BalanceResponse"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentBalance($param, $args)
    {
        $balance = (new MTransactions())->calcBalance('student', (int)$args['id']);
        return new BalanceResponse($balance);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/attendances",
     *     summary="Посещения ученика",
     *     operationId="getStudentAttendances",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/AttendanceStudent")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentAttendances($param, $args)
    {
        return (new MAttendances())->getListForStudent((int)$args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/loyalty",
     *     summary="Оценки педагов ученика",
     *     operationId="getStudentTeachersScore",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/StudentScore")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentTeachersScore($param, $args)
    {
        return (new MLoyalty())->getScoresForStudent((int)$args['id']);
    }

    /**
     * @SWG\POST(
     *     path="/api/students/{id}/loyalty",
     *     summary="Обновить оценку педагогу",
     *     operationId="updateTeacherScore",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/StudentScore"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Ученик не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function updateTeacherScore($param, $args)
    {
        (new MLoyalty())->updateStudentTeacherScore((int)$args['id'], $param);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/groups",
     *     summary="Группы ученика",
     *     operationId="getGroupsStudent",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Group")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getGroupsStudent($param, $args)
    {
        return (new MGroups())->getGroupsStudent((int)$args['id']);
    }

    /**
     * @SWG\Get(
     *     path="/api/students",
     *     summary="Список учеников",
     *     operationId="getStudents",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Student")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudents($param, $args)
    {
        return (new MStudents())->getList($args);
    }

    /**
     * @SWG\Post(
     *     path="/api/students",
     *     summary="Добавить ученика",
     *     operationId="addStudent",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/StudentForm"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     ),
     *     @SWG\Response(
     *         response="404", description="Ученик не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function addStudent($param)
    {
        $studentId = (new MStudents())->addStudent($param);
        // TODO при создании сущностей должен возвращаться BaseResponse
        return new BaseResponse(true, null, $studentId);
    }

    /**
     * @SWG\Patch(
     *     path="/api/students/{id}",
     *     summary="Редактировать ученика",
     *     operationId="editStudent",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Student"),
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
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
     *         response="404", description="Ученик не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function editStudent($param, $args)
    {
        (new MStudents())->updateStudent($param, (int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Delete(
     *     path="/api/students/{id}",
     *     summary="Удалить ученика",
     *     operationId="deleteStudent",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
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
     *         response="404", description="Ученик не найден",
     *     )
     * )
     */
    public function deleteStudent($param, $args)
    {
        (new MStudents())->deleteStudent((int)$args['id']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/courses",
     *     summary="Список курсов ученика",
     *     operationId="getStudentsCourses",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/StudentCourse")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentCourses($param, $args)
    {
        return (new MStudentCourses())->getStudentCourses((int)$args['id']);
    }


    /**
     * @SWG\Delete(
     *     path="/api/students/{studentId}/courses/{courseId}",
     *     summary="Удалить курс ученика",
     *     operationId="deleteStudentCourse",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
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
     *         @SWG\Schema(ref="#/definitions/BaseResponse"),
     *     ),
     *     @SWG\Response(response=403, description="Нет доступа"),
     *     @SWG\Response(
     *         response="404", description="Ученик не найден",
     *     )
     * )
     */
    public function deleteStudentCourse($param, $args)
    {
        (new MStudentCourses())->deleteStudentCourse((int)$args['studentId'], (int)$args['courseId']);
        return new BaseResponse(true);
    }

    /**
     * @SWG\Post(
     *     path="/api/students/{studentId}/courses/{courseId}",
     *     summary="Добавить курс ученику",
     *     operationId="addStudentCourse",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="studentId",
     *         in="path",
     *         description="ID ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Parameter(
     *         name="courseId",
     *         in="path",
     *         description="ID курса",
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
     *         response="404", description="Ученик не найден",
     *         @SWG\Schema(ref="#/definitions/BaseResponse")
     *     )
     * )
     */
    public function addStudentCourse($param, $args)
    {
        return (new MStudentCourses())->addStudentCourse((int)$args['studentId'], (int)$args['courseId']);
    }

    /**
     * @SWG\Get(
     *     path="/api/students/{id}/manuals",
     *     summary="Методички для ученика",
     *     operationId="getStudentManuals",
     *     produces={"application/json"},
     *     tags={"student"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Ученика",
     *         required=true,
     *         type="integer",
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/StudentManualsResponse"),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Нет доступа для выполнения операции",
     *     )
     * )
     */
    public function getStudentManuals($param, $args): StudentManualsResponse
    {
        $modelLinks = new MLinks();
        $linksCourse = $modelLinks->getLinksForStudentCourse((int)$args['id']);
        $linksStudent = $modelLinks->getLinksForStudent((int)$args['id']);
        return new StudentManualsResponse($linksCourse, $linksStudent);
    }
}