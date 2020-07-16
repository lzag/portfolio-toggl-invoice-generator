<?php
namespace App\Model;

use App\Helper;

class ClientData
{
    private $client_data;

    private $company_name;

    private $company_address;

    private $company_country;

    private $contact_name;

    private $contact_email;

    public function __construct($client_name)
    {
        $this->client_data = Helper::configValue('clients.' . $client_name);
        if ($this->client_data) {
            $this->company_name = $this->client_data['company_name'];
            $this->company_address = $this->client_data['company_address'];
            $this->company_country = $this->client_data['company_country'];
            $this->contact_name = $this->client_data['contact_name'];
            $this->contact_email = $this->client_data['contact_email'];
        }
    }

    public function getCompanyName()
    {
        return $this->company_name;
    }

    public function getCompanyAddress()
    {
        return $this->company_address;
    }

    public function getCompanyCountry()
    {
        return $this->company_country;
    }

    public function getContactName()
    {
        return $this->contact_name;
    }

    public function getContactEmail()
    {
        return $this->contact_email;
    }
}
