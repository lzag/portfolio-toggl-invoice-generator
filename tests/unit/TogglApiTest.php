<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Model\TogglApi;
use App\Model\SummaryProjectData;

final class TogglApiTest extends TestCase
{
    public function testCanDownloadSummaryReport()
    {

        $api = new TogglApi();
        $response = $api->getSummaryReport('2020-05-20', '2020-05-27');
        $this->assertSame(200, $response['response_code']);
        $this->assertNotEmpty($response['summary']);
        $this->assertIsObject($response['summary']);
    }
}
