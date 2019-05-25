<?php

class HttpMethod
{
    static $GET = 'GET';
    static $POST = 'POST';
    static $PATCH = 'PATCH';
    static $DELETE = 'DELETE';
}

class Role
{
    static $admin = 'admin';
    static $manager = 'manager';
    static $corporate = 'corporate';
    static $student = 'student';
    static $teacher = 'teacher';
}

use app\SimpleRooting;

$config = include __DIR__ . './../config.php';

$routes = new SimpleRooting($config['prefix'], $config['fullRest']);

$routes->addSimple('/user', 'Users', 'getUser', HttpMethod::$GET);
$routes->addSimple('/user/logout', 'Users', 'logoutUser', HttpMethod::$GET);

$routes->addSimple('/users', 'Users', 'getList', HttpMethod::$GET,
    ["admin", "manager"]);
$routes->addSimple('/users', 'Users', 'addUser', HttpMethod::$POST,
    ["admin"]);
$routes->addSimple('/users/{id}', 'Users', 'getUserById', HttpMethod::$GET,
    ["admin", "manager", "corporate" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/users/{id}', 'Users', 'editUser', HttpMethod::$PATCH,
    ["admin"]);
$routes->addSimple('/users/{id}', 'Users', 'deleteUser', HttpMethod::$DELETE,
    ["admin"]);

$routes->addSimple('/auth', 'Users', 'authUser', HttpMethod::$POST);

$routes->addSimple('/students', 'Students', 'getStudents', HttpMethod::$GET,
    ["admin", "manager", "corporate" => [
        'corporate_manager' => 'userId'
    ], "teacher"]);
$routes->addSimple('/students', 'Students', 'addStudent', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/students/{id}', 'Students', 'getStudent', HttpMethod::$GET,
    ["admin", "manager", "corporate" => [
        'corporate_manager' => 'userId'
    ], "teacher", "student" => [
        'id' => 'userId'
    ]]);
// Не защищён от корпоративного клиента
$routes->addSimple('/students/{id}/groups', 'Students', 'getGroupsStudent', HttpMethod::$GET,
    ["admin", "manager", "corporate", "teacher", "student" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/students/{id}/balance', 'Students', 'getStudentBalance', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student" => [
        'id' => 'userId'
    ]]);
// Не защищён от корпоративного клиента
$routes->addSimple('/students/{id}/attendances', 'Students', 'getStudentAttendances', HttpMethod::$GET,
    ["admin", "manager", "corporate", "teacher", "student" => [
        'id' => 'userId'
    ]]);
// Не защищён от корпоративного клиента
$routes->addSimple('/students/{id}/loyalty', 'Students', 'getStudentTeachersScore', HttpMethod::$GET,
    ["admin", "manager", "corporate", "student" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/students/{id}/loyalty', 'Students', 'updateTeacherScore', HttpMethod::$POST,
    ["admin", "manager", "student" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/students/{id}', 'Students', 'editStudent', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/students/{id}', 'Students', 'deleteStudent', HttpMethod::$DELETE,
    ["admin", "manager"]);
// Не защищён от корпоративного клиента
$routes->addSimple('/students/{id}/courses', 'Students', 'getStudentCourses', HttpMethod::$GET,
    ["admin", "manager", "corporate", "student" => [
        'id' => 'userId'
    ]]);
// Не защищён от корпоративного клиента
$routes->addSimple('/students/{id}/manuals', 'Students', 'getStudentManuals', HttpMethod::$GET,
    ["admin", "manager", "corporate", "student" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/students/{studentId}/courses/{courseId}', 'Students', 'deleteStudentCourse', HttpMethod::$DELETE,
    ["admin", "manager"]);
$routes->addSimple('/students/{studentId}/courses/{courseId}', 'Students', 'addStudentCourse', HttpMethod::$POST,
    ["admin", "manager"]);

$routes->addSimple('/teachers', 'Teachers', 'getTeachers', HttpMethod::$GET,
    ["admin", "manager", "corporate", "teacher", "student"]);
$routes->addSimple('/teachers', 'Teachers', 'addTeacher', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/teachers/{id}', 'Teachers', 'editTeacher', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/teachers/{id}', 'Teachers', 'deleteTeacher', HttpMethod::$DELETE,
    ["admin", "manager"]);
$routes->addSimple('/teachers/{id}', 'Teachers', 'getTeacher', HttpMethod::$GET,
    ["admin", "manager", "teacher" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/teachers/{id}/groups', 'Teachers', 'getTeacherGroups', HttpMethod::$GET,
    ["admin", "manager", "teacher" => [
        'id' => 'userId'
    ]]);
$routes->addSimple('/teachers/{id}/attendances', 'Teachers', 'getTeacherAttendances', HttpMethod::$GET,
    ["admin", "manager", "teacher" => [
        'id' => 'userId'
    ]]);

$routes->addSimple('/groups', 'Groups', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate" => [
        'corporate_manager' => 'userId'
    ]]);
$routes->addSimple('/groups', 'Groups', 'addGroup', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/groups/{id}', 'Groups', 'getItem', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/groups/{id}', 'Groups', 'editGroup', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/groups/{id}', 'Groups', 'deleteGroup', HttpMethod::$DELETE,
    ["admin", "manager"]);
// Не защищён от corporate
$routes->addSimple('/groups/{id}/students', 'Groups', 'getStudentsList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
// Не защищён от corporate
$routes->addSimple('/groups/{id}/statistic', 'Groups', 'getStatisticStudents', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/groups/{groupId}/students/{studentId}', 'Groups', 'deleteStudent', HttpMethod::$DELETE,
    ["admin", "manager"]);
$routes->addSimple('/groups/{groupId}/students/{studentId}', 'Groups', 'addStudent', HttpMethod::$POST,
    ["admin", "manager", "teacher"]);
$routes->addSimple('/groups/{groupId}/attendances/{year}/{month}/{day}',
    'Groups', 'getAttendancesByDate', HttpMethod::$GET,
    ["admin", "manager", "teacher"]);
$routes->addSimple('/groups/{groupId}/attendances/{year}/{month}/{day}/{hour}/{minute}',
    'Groups', 'getAttendancesByDateTime', HttpMethod::$GET,
    ["admin", "manager", "teacher"]);
$routes->addSimple('/groups/{groupId}/attendances',
    'Groups', 'addAttendance', HttpMethod::$POST,
    ["admin", "manager", "teacher", "corporate"]);
$routes->addSimple('/groups/{groupId}/status/{status}', 'Groups', 'editStatusGroup', HttpMethod::$PATCH,
    ["admin", "manager"]);

$routes->addSimple('/sources', 'Sources', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/sources/{id}', 'Sources', 'deleteSource', HttpMethod::$DELETE,
	["admin", "manager"]);
$routes->addSimple('/sources', 'Sources', 'addSource', HttpMethod::$POST,
	["admin", "manager"]);
$routes->addSimple('/sources/{id}', 'Sources', 'editSource', HttpMethod::$PATCH,
	["admin", "manager"]);

$routes->addSimple('/langs', 'Langs', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/langs', 'Langs', 'addLang', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/langs/{id}', 'Langs', 'editLang', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/langs/{id}', 'Langs', 'deleteLang', HttpMethod::$DELETE,
    ["admin", "manager"]);

$routes->addSimple('/courses', 'Courses', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/courses', 'Courses', 'add', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/courses/{id}', 'Courses', 'edit', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/courses/{id}', 'Courses', 'delete', HttpMethod::$DELETE,
    ["admin", "manager"]);
$routes->addSimple('/courses/{id}', 'Courses', 'getCourse', HttpMethod::$GET,
    ["admin", "manager"]);

$routes->addSimple('/leads', 'Leads', 'getList', HttpMethod::$GET,
    ["admin", "manager"]);
$routes->addSimple('/leads/statistic', 'Leads', 'getStatisticByDate', HttpMethod::$GET,
    ["admin", "manager"]);
$routes->addSimple('/leads', 'Leads', 'add', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/leads/{id}', 'Leads', 'edit', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/leads/{id}', 'Leads', 'delete', HttpMethod::$DELETE,
    ["admin", "manager"]);

$routes->addSimple('/leads/statuses', 'Leads', 'getStatusList', HttpMethod::$GET,
	["admin", "manager"]);
$routes->addSimple('/leads/statuses', 'Leads', 'addStatus', HttpMethod::$POST,
	["admin", "manager"]);
$routes->addSimple('/leads/statuses/{id}', 'Leads', 'editStatus', HttpMethod::$PATCH,
	["admin", "manager"]);
$routes->addSimple('/leads/statuses/{id}', 'Leads', 'deleteStatus', HttpMethod::$DELETE,
	["admin", "manager"]);

$routes->addSimple('/categories', 'Categories', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);

$routes->addSimple('/levels', 'Levels', 'getList', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);

$routes->addSimple('/lessons/group/{groupId}', 'Lessons', 'getListGroup', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/lessons/group/{groupId}', 'Lessons', 'addLesson', HttpMethod::$POST,
    ["admin", "manager", "teacher", "corporate"]);
$routes->addSimple('/lessons/{id}', 'Lessons', 'getItem', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student"]);
$routes->addSimple('/lessons/{id}', 'Lessons', 'editLesson', HttpMethod::$PATCH,
    ["admin", "manager", "teacher"]);
$routes->addSimple('/lessons/{id}', 'Lessons', 'deleteLesson', HttpMethod::$DELETE,
    ["admin", "manager", "teacher"]);
$routes->addSimple('/lessons/teacher/{teacherId}', 'Lessons', 'getLessonsTeacher', HttpMethod::$GET,
    ["admin", "manager", "teacher"]);

$routes->addSimple('/transactions/student/{id}', 'Transactions', 'getListStudent', HttpMethod::$GET,
    ["admin", "manager", "student"]);
$routes->addSimple('/transactions/student/{id}', 'Transactions', 'addTransactionStudent', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/transactions/{id}', 'Transactions', 'editTransaction', HttpMethod::$PATCH,
    ["admin", "manager"]);
$routes->addSimple('/transactions/{id}', 'Transactions', 'deleteTransaction', HttpMethod::$DELETE,
    ["admin", "manager"]);
$routes->addSimple('/transactions/corporate-user/{id}', 'Transactions', 'getTransactionsCorporateUser', HttpMethod::$GET,
    ["admin", "manager", "student", "corporate" => [
        "id" => "userId"
    ]]);
$routes->addSimple('/transactions/corporate-user/{id}/balance', 'Transactions', 'getBalanceCorporateUser', HttpMethod::$GET,
    ["admin", "manager", "student", "corporate" => [
        "id" => "userId"
    ]]);
$routes->addSimple('/transactions/user/{id}', 'Transactions', 'addTransactionUser', HttpMethod::$POST,
    ["admin", "manager"]);

$routes->addSimple('/attendances/statuses', 'Attendances', 'getStatuses', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/attendances', 'Attendances', 'updateLessonAttendee', HttpMethod::$POST,
    ["admin", "manager", "teacher"]);

$routes->addSimple('/links/course/{courseId}', 'Links', 'getLinksCourse', HttpMethod::$GET,
    ["admin", "manager", "teacher", "student", "corporate"]);
$routes->addSimple('/links/course/{courseId}', 'Links', 'addLinksCourse', HttpMethod::$POST,
    ["admin", "manager"]);
$routes->addSimple('/links/student/{studentId}', 'Links', 'addLinksStudent', HttpMethod::$POST,
    ["admin", "manager"]);

$routes->addSimple('/statistic', 'Statistics', 'getTotalStatistic', HttpMethod::$GET,
    ["admin", "manager"]);

$routes->addSimple('/docs/student-contract/{studentId}/{groupId}', 'Docs', 'getStudentContract', HttpMethod::$GET,
    ["admin", "manager", "student" => [
        'id' => 'userId'
    ]]);

$routes->addSimple('/ping', 'Ping', 'ping', HttpMethod::$GET);

$routes->addSimple('/migrate', 'Migrate', 'migrate', HttpMethod::$GET, ["admin"]);

return $routes;
