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
        ];
        $my_name = Helper::configValue('my_data.my_name', $config);
        $this->assertSame('Kareem Johnson', $my_name);

        $toggl_token = Helper::configValue('toggl.api_token', $config);
        $this->assertSame('12345', $toggl_token);
    }
}
