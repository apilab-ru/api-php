<?php

/**
 * @SWG\Definition(required={"name", "email", "password"}, type="object", @SWG\Xml(name="User"))
 */

namespace app\entity;

class User extends Base
{
    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Имя")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(title="Компания")
     * @var string
     */
    public $company;

    /**
     * @SWG\Property(title="Email")
     * @var string
     */
    public $email;

    /**
     * @SWG\Property(title="Пароль")
     * @var string
     */
    protected $password;

    /**
     * @SWG\Property(title="Тип пользователя", enum={"corporate", "manager", "admin"})
     * @var string
     */
    public $role;

    /**
     * @SWG\Property(title="Фото")
     * @var string
     */
    public $photo;

    /**
     * @SWG\Property(title="Кука")
     * @var string
     */
    public $cookie;

    protected $types = [
        'id' => 'integer'
    ];
}