<?php
namespace App\Model;

use App\Helper;

class BankData
{

    private $account_number;

    public function __construct()
    {
        $this->account_number = Helper::configValue('bank_data.account_number');
    }

    public function getAccountNumber()
    {
        return $this->account_number;
    }
}
