<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Helper;

final class HelperTest extends TestCase
{
    public function testCanRetrieveConfigOption()
    {

        $config = [
            'toggl' => [
                'api_token' => '12345',
            ],
            'my_data' => [
                'my_name' => 'Kareem Johnson',
            ],
            'clients' => [
                'Dummy' => [
                    'company_name'    => 'Dummy',
                    'company_address1'=> 'Company address',
                    'company_address2'=> 'Address Line 2',
                    'company_address3'=> '',
                    'company_country' => 'Great Britain',
                    'contact_name'    => 'John Lee',
                    'contact_email'   => 'j.lee@facebeek.com',
                ],
            ],
        ];
        $my_name = Helper::configValue('my_data.my_name', $config);
        $company_address = Helper::configValue('clients.Dummy.company_address1', $config);
        $contact_name = Helper::configValue('clients.Dummy.contact_name', $config);
        $this->assertSame('Kareem Johnson', $my_name);
        $this->assertSame('Company address', $company_address);
        $this->assertSame('John Lee', $contact_name);

        $toggl_token = Helper::configValue('toggl.api_token', $config);
        $this->assertSame('12345', $toggl_token);
    }
}
