<?php

/**
 * @SWG\Definition(required={"name", "email", "password"}, type="object", @SWG\Xml(name="Teacher"))
 */

namespace app\entity;

class Teacher extends Base
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
     * @SWG\Property(title="Тип пользователя", enum={"teacher"})
     * @var string
     */
    public $role = "teacher";

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
    /**
     * @SWG\Property(title="Телефон")
     * @var string
     */
    public $phone;

    /**
     * @SWG\Property(title="Пол", enum={"male", "female"})
     * @var string
     */
    public $sex;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="День рождения")
     * @var date
     */
    public $birthday;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="День рождения")
     * @var date
     */
    public $employment_date;

    /**
     * @SWG\Property(title="Дата трудоустройства")
     * @var date
     */
    public $description;

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $rate;


    protected $types = [
        "id" => "integer",
        "birthday" => "date",
        "employment_date" => "date",
        "rate" => "integer"
    ];

    public function serializeToBd():array {
        $data = parent::serializeToBd();
        unset($data['role']);
        unset($data['rate']);
        return $data;
    }
}