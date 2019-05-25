<?php

/**
 * @SWG\Definition(required={"name", "email", "password"}, type="object", @SWG\Xml(name="TeacherDetail"))
 */

namespace app\entity;

class TeacherDetail extends Base
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

    // TODO расписать $categories, $courses, $langs
    /**
     * @SWG\Property(title="Категории")
     * @var date
     */
    public $categories;

    /**
     * @SWG\Property(title="Курсы")
     * @var date
     */
    public $courses;

    /**
     * @SWG\Property(title="Языки")
     * @var date
     */
    public $langs;


    protected $types = [
        "id" => "integer",
        "birthday" => "date",
        "employment_date" => "date"
    ];

    public function serializeToBd():array {
        $data = parent::serializeToBd();
        unset($data['role']);
        unset($data['categories']);
        unset($data['courses']);
        unset($data['langs']);
        return $data;
    }
}