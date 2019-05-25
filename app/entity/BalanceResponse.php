<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="BalanceResponse"))
 */

namespace app\entity;

class BalanceResponse
{
    /**
     * @SWG\Property(title="Баланс")
     * @var float
     */
    public $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }
}