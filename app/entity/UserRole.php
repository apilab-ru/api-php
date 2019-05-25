<?php

/**
 * @SWG\Definition( type="enum", @SWG\Xml(name="UserRole"))
 */

namespace app\entity;

class UserRole
{
    const NONE = 'none';
    const MANAGER = 'manager';
    const ADMIN = 'admin';
    const TEACHER = 'teacher';
    const STUDENT = 'student';
}