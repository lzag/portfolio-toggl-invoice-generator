<?php
namespace App\Model;

use App\Helper;

class ClientData
{
    private $client_data;

    private $company_name;

    private $company_address = [];

    private $company_country;

    private $contact_name;

    private $contact_email;

    public function __construct(
        $mode = 'db',
        $company_name = '',
        $company_country = '',
        $company_address = [],
        $contact_name = '',
        $contact_email = ''
    ) {
        if ($mode === 'db') {
            $this->client_data = Helper::configValue('clients.' . $company_name);
            if ($this->client_data) {
                $this->company_name = $this->client_data['company_name'];
                array_push(
                    $this->company_address,
                    $this->client_data['company_address1'],
                    $this->client_data['company_address2'],
                    $this->client_data['company_address3']
                );
                // filtering the empty address fields
                $this->company_address = array_filter($this->company_address);
                $this->company_country = $this->client_data['company_country'];
                $this->contact_name = $this->client_data['contact_name'];
                $this->contact_email = $this->client_data['contact_email'];
            }
        } elseif ($mode === 'new') {
            $this->company_name = $company_name;
            $this->company_country = $company_country;
            $this->company_address = $company_address;
            $this->contact_name = $contact_name;
            $this->contact_email = $contact_email;
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

    public function getFormattedAddress()
    {
        return implode('</w:t><w:br/><w:t>', $this->company_address);
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
