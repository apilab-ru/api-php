<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="BaseResponse"))
 */

namespace app\entity;

class BaseResponse
{
    /**
     * @SWG\Property(title="Статус")
     * @var boolean
     */
    public $success;

    /**
     * @SWG\Property(title="Текст ошибки")
     * @var string
     */
    public $error;

    /**
     * @SWG\Property(title="ID добавленной сущности")
     * @var integer
     */
    public $id;

    public function __construct($success, $error = null, $id = null)
    {
        $this->success = $success;
        if ($id) {
            $this->id = $id;
        } else {
            unset($this->id);
        }

        if (!$error) {
            unset($this->error);
        } else {
            $this->error = $error;
        }
    }
}