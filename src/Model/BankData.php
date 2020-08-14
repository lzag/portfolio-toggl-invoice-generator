<?php
namespace App\Model;

use App\Helper;

class BankData
{

    private $entity_name;
    private $account_number;
    private $transit_number;
    private $institution_number;
    private $swift;

    public function __construct(
        $mode = 'default',
        $entity_name = '',
        $account_number = '',
        $transit_number = '',
        $institution_number = '',
        $swift = ''
    ) {
        if ($mode === 'default') {
            $this->entity_name = Helper::configValue('bank_data.entity_name');
            $this->account_number = Helper::configValue('bank_data.account_number');
            $this->transit_number = Helper::configValue('bank_data.transit_number');
            $this->institution_number = Helper::configValue('bank_data.institution_number');
            $this->swift = Helper::configValue('bank_data.swift');
        } elseif ($mode === 'new') {
            $this->entity_name = $entity_name;
            $this->account_number = $account_number;
            $this->transit_number = $transit_number;
            $this->institution_number = $institution_number;
            $this->swift = $swift;
        }
    }

    public function getEntityName()
    {
        return $this->entity_name;
    }

    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function getTransitNumber()
    {
        return $this->transit_number;
    }

    public function getInstitutionNumber()
    {
        return $this->institution_number;
    }

    public function getSwift()
    {
        return $this->swift;
    }
}
