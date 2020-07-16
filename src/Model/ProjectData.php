<?php
namespace App\Model;

class ProjectData
{
    /*
     * @param string
     */
    private $title;

     /*
      * @param array
      */
    private $entries;

    /*
     * @param int
     */
    private $total_hours;

    public function __construct($data)
    {
        $this->title = $data->title->project;
        $this->total_hours = intdiv($data->time, 3600000);
        foreach ($data->items as $item) {
            $this->entries[] = $item->title->time_entry;
        }
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getEntriesWithLineBreaks()
    {
        $entries = implode("\n", $this->entries);
        return $entriesWithLineBreaks = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $entries);
    }
    public function getTotalHours()
    {
        return $this->total_hours;
    }
}
