<?php

return [
    "Users" => [
        "getUserById" => ["admin", "manager"],
        "getList" => ["admin"]
    ],
    "Students" => [
        "getStudents" => ["admin", "manager", "teacher"],
        "addStudent" => ["admin", "manager"],
        "updateStudent" => ["admin", "manager"],
        "deleteStudent" => ["admin", "manager"]
    ],
    "Sources" => [
        "getList" => ["admin", "manager", "teacher", "student"]
    ],
    "Langs" => [
        "getList" => ["admin", "manager", "teacher", "student"],
        "addLang" => ["admin", "manager"],
        "updateLang" => ["admin", "manager"],
        "deleteLang" => ["admin", "manager"]
    ],
    "Leads" => [
        "getList" => ["admin", "manager"],
        "add" => ["admin", "manager"],
        "update" => ["admin", "manager"],
        "delete" => ["admin", "manager"]
    ],
    "Teachers" => [
        "getTeachers" => ["admin", "manager", "teacher", "student"],
        "addTeacher" => ["admin", "manager"],
        "updateTeacher" => ["admin", "manager"],
        "deleteTeacher" => ["admin", "manager"]
    ]
];

