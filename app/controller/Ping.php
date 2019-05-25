<?php

namespace app\controller;

use app\entity\BaseResponse;

class Ping extends Base{

  public function ping()
  {
    return new BaseResponse(true);
  }

}
