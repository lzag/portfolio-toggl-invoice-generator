<?php
namespace App\Model;

use App\Helper;

class PersonalInfo
{
    private $my_name;
    private $my_email;
    private $my_phone;
    private $my_address1;
    private $my_address2;

    public function __construct(
        $mode = 'default',
        $my_name = '',
        $my_email = '',
        $my_phone = '',
        $my_address1 = '',
        $my_address2 = ''
    ) {
        if ($mode === 'default') {
            $this->my_name = Helper::configValue('my_data.my_name');
            $this->my_phone = Helper::configValue('my_data.my_phone');
            $this->my_email = Helper::configValue('my_data.my_email');
            $this->my_address1 = Helper::configValue('my_data.my_address1');
            $this->my_address2 = Helper::configValue('my_data.my_address2');
        } elseif ($mode === 'new') {
            $this->my_name = $my_name;
            $this->my_email = $my_email;
            $this->my_phone = $my_phone;
            $this->my_address1 = $my_address1;
            $this->my_address2 = $my_address2;
        }
    }

    public function getMyName()
    {
        return $this->my_name;
    }

    public function getMyEmail()
    {
        return $this->my_email;
    }

    public function getMyPhone()
    {
        return $this->my_phone;
    }

    public function getMyAddress1()
    {
        return $this->my_address1;
    }

    public function getMyAddress2()
    {
        return $this->my_address2;
    }
}
