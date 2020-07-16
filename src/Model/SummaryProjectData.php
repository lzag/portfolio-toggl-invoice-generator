<?php
namespace App\Model;

use App\Model\ProjectData;
use App\Model\TogglApi;

class SummaryProjectData
{
    /*
     * @param array
     */
    private $projects = [];

    /*
     * @param string
     */
    private $total_hours;

    public function __construct(TogglApi $api, $start_date, $end_date, $client)
    {
        $response = $api->getSummaryReport($start_date, $end_date);

        if ($response['response_code'] === 200) {
            $this->total_hours = 0;
            foreach ($response['summary']->data as $project) {
                if ($project->title->client === $client) {
                    $this->total_hours += $project->time;
                    $this->projects[] = new ProjectData($project);
                } else {
                    continue;
                }
            }
            $this->total_hours = intdiv($this->total_hours, 3600000);
        }
    }

    public function getTotalHours()
    {
        return $this->total_hours;
    }

    public function getProjects()
    {
        return $this->projects;
    }
}
