<?php

/**
 * @SWG\Definition( type="enum", @SWG\Xml(name="TransactionTypes"))
 */

namespace app\entity;

class TransactionTypes
{
    const DEPOSIT = 'deposit';
    const PAYMENT = 'payment';
    const WITHDRAWAL = 'withdrawal';
}