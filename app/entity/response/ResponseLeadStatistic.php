<?php
/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ResponseLeadStatistic"))
 */

namespace app\entity\response;
use app\entity\Base;

class ResponseLeadStatistic extends Base
{
    public $list;

    public $totalStatistic;
}