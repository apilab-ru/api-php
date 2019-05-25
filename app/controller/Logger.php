<?php

namespace app\controller;

class Logger extends Base{
    
    public function log()
    {
        $list = (new \app\model\log())->getList();
        
        pr($list);
    }
    
    public function clear()
    {
        (new \app\model\log())->clear();
    }
    
}
