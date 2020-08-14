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

    private $start_date;

    private $end_date;

    public function __construct($start_date, $end_date, $client)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->client = $client;
    }

    /*
     * Accepts an array of ProjectData objects
     *
     * @param array
     */
    public function addProjects($projects)
    {
        $this->total_hours = 0;
        foreach ($projects as $projects) {
            $this->total_hours += $project->getTotalHours();
        }
        $this->projects = $projects;
    }

    public function fetchProjects(TogglApi $api)
    {
        $response = $api->getSummaryReport($this->start_date, $this->end_date);

        if ($response['response_code'] === 200) {
            $this->total_hours = 0;
            foreach ($response['summary']->data as $project) {
                if ($project->title->client === $this->client) {
                    $this->total_hours += $project->time;
                    $items= [];
                    foreach ($project->items as $item) {
                        $items[] = $item->title->time_entry;
                    }
                    $this->projects[] = new ProjectData($project->title->project, $project->time, $items);
                } else {
                    continue;
                }
            }
            $this->total_hours = (int) round($this->total_hours / 3600000);
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
