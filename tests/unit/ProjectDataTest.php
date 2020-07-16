<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Model\ProjectData;

final class ProjectDataTest extends TestCase
{
    public function testCanObtainProjectData()
    {
        $data = <<<'API'
                {
                    "id": 160790227,
                    "title": {
                        "project": "Testing API",
                        "client": "Test Client",
                        "color": "0",
                        "hex_color": "#bf7000"
                    },
                    "time": 17700000,
                    "total_currencies": [
                    {
                        "currency": null,
                        "amount": null
                    }
                    ],
                    "items": [
                    {
                        "title": {
                            "time_entry": "Tests"
                        },
                        "time": 17700000,
                        "cur": null,
                        "sum": null,
                        "rate": null
                    },
                    {
                        "title": {
                            "time_entry": "Some more tests 2"
                        },
                        "time": 0,
                        "cur": null,
                        "sum": null,
                        "rate": null
                    }
                    ]
                }
API;

        $data = json_decode($data);
        $projectData = new ProjectData($data);
        $this->assertSame(2, count($projectData->getEntries()));
        $this->assertSame('Testing API', $projectData->getTitle());
        $this->assertSame(4, $projectData->getTotalHours());
        $this->assertSame('Some more tests 2', $projectData->getEntries()[1]);
    }
}
