<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Model\SummaryProjectData;
use App\Model\TogglApi;

final class SummaryProjectDataTest extends TestCase
{
    public function testCanProcessSummaryProjectData()
    {
        $data = <<<'API'
        {
            "total_grand": 21300000,
                "total_billable": null,
                "total_currencies": [
                {
                    "currency": null,
                    "amount": null
                }
                ],
                "data": [
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
                            "time_entry": "Testing API"
                        },
                        "time": 17700000,
                        "cur": null,
                        "sum": null,
                        "rate": null
                    }
                    ]
                },
                {
                    "id": 160492744,
                    "title": {
                        "project": "Testing 2",
                        "client": "Test Client",
                        "color": "0",
                        "hex_color": "#d92b2b"
                    },
                    "time": 3600000,
                    "total_currencies": [
                    {
                        "currency": null,
                        "amount": null
                    }
                    ],
                    "items": [
                    {
                        "title": {
                            "time_entry": "Some more tests"
                        },
                        "time": 3600000,
                        "cur": null,
                        "sum": null,
                        "rate": null
                    }
                    ]
                }
                ]
        }
API;

        $projectSummary  = new SummaryProjectData('2020-03-05', '2020-07-01', 'Dummy');
        $projectSummary->fetchProjects(new TogglApi);
        $this->assertSame(7, $projectSummary->getTotalHours());
        $this->assertSame(1, count($projectSummary->getProjects()));
    }
}
