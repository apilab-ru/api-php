<?php

/**
 * @SWG\Definition(required={"name", "email", "password"}, type="object", @SWG\Xml(name="Student"))
 */

namespace app\entity;

class StudentForm extends User
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
     * @SWG\Property(title="Тип пользователя", enum={"student"})
     * @var string
     */
    public $role = "student";

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
     * @SWG\Property(title="Адрес")
     * @var string
     */
    public $address;

    /**
     * @SWG\Property(title="Ids откуда пришёл")
     * @var number
     */
    public $sources;

    /**
     * @SWG\Property(title="ID языка")
     * @var number
     */
    public $lang_id;

    /**
     * @SWG\Property(title="ID уровня")
     * @var number
     */
    public $level_id;

    /**
     * @SWG\Property(title="ID категории")
     * @var number
     */
    public $category_id;

    /**
     * @SWG\Property(title="Лояльность 1-10")
     * @var number
     */
    public $loyalty;

    /**
     * @SWG\Property(title="ФИО родителей")
     * @var string
     */
    public $parent_name;

    /**
     * @SWG\Property(title="Номер родителей")
     * @var string
     */
    public $parent_phone;

    /**
     * @SWG\Property(title="Школа")
     * @var string
     */
    public $school;

    /**
     * @SWG\Property(title="Паспорт")
     * @var string
     */
    public $passport;

    /**
     * @SWG\Property(title="Номер договора")
     * @var string
     */
    public $contract_number;

    // TODO правильная анотация здесь и в source
    /**
     * @SWG\Property(title="Группы")
     * @var number
     */
    public $groups;

    protected $types = [
        'id' => 'integer',
        'source_id' => 'integer',
        'lang_id' => 'integer',
        'level_id' => 'integer',
        'category_id' => 'integer',
        'birthday' => 'date',
        'sources' => 'ids'
    ];

    public function serializeToBd():array {
        $data = parent::serializeToBd();
        unset($data['role']);
        return $data;
    }
}