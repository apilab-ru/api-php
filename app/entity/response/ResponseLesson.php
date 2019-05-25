<?php
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ResponseLesson"))
 */

namespace app\entity\response;
use app\entity\Base;

class ResponseLesson extends Base
{

    /**
     * @SWG\Property(format="int64")
     * @var integer
     */
    public $id;

    /**
     * @SWG\Property(title="Домашнее задание")
     * @var string
     */
    public $home_work;


    /**
     * @SWG\Property(title="Список посещений учеников",
     *    @SWG\Schema(
            type="array",
            @SWG\Items(ref="#/definitions/AttendeeDetail")
          )
    )
    */
    public $list = [];

}