<?php
namespace App\Model;

use App\Helper;
use \App\Model\Database;

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
            $db = new Database;
            $db->connect();
            $conn = $db->getConn();
            $sql = "
                SELECT
                company_name,
                company_address1,
                company_address2,
                company_address3,
                company_country,
                contact_name,
                contact_email
                FROM
                clients
                WHERE
                company_name = ?
                ";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$company_name]);
            $result = $stmt->fetchObject();
            if ($result) {
                $this->company_name = $result->company_name;
                array_push(
                    $this->company_address,
                    $result->company_address1,
                    $result->company_address2,
                    $result->company_address3
                );
                $this->company_country = $result->company_country;
                $this->contact_name = $result->contact_name;
                $this->contact_email = $result->contact_email;
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
        return implode('</w:t><w:br/><w:t>', array_filter($this->company_address));
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
