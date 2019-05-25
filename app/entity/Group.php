<?php

/**
 * @SWG\Definition(required={"teacher_id", "lang_id", "name"}, type="object", @SWG\Xml(name="Group"))
 */

namespace app\entity;

class Group extends Base
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
     * @SWG\Property(title="Статус", enum={"work", "recruiting", "other", "archive"})
     * @var string
     */
    public $status;

    /**
    * @SWG\Property(title="Стоимость занятия")
    * @var integer
    */
    public $cost;

    /**
     * @SWG\Property(title="Уровень")
     * @var integer
     */
    public $level_id;

    /**
     * @SWG\Property(title="Язык")
     * @var integer
     */
    public $lang_id;

    /**
     * @SWG\Property(title="Педагог")
     * @var integer
     */
    public $teacher_id;

    /**
     * @SWG\Property(title="Курс")
     * @var integer
     */
    public $course_id;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата начала")
     * @var date
     */
    public $date_start;

    /**
     * @SWG\Property(ref="#/definitions/DateDto", title="Дата окончания")
     * @var date
     */
    public $date_end;

    /**
     * @SWG\Property(title="Заметка")
     * @var string
     */
    public $note;

    /**
     * @SWG\Property(title="Тип посещения", enum={"daytime", "evening"})
     * @var string
     */
    public $type_visit;

    /**
     * @SWG\Property(title="Адрес")
     * @var string
     */
    public $address;

    protected $types = [
        'id' => 'integer',
        'level_id'=> 'integer',
        'lang_id'=> 'integer',
        'teacher_id'=> 'integer',
        'cost' => 'real',
        'course_id'=> 'integer',
        'date_start' => 'date',
        'date_end' => 'date'
    ];
}