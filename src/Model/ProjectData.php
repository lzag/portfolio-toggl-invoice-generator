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

    public function __construct($title, $total_hours, array $items)
    {
        $this->title = $title;
        $this->total_hours = $total_hours;
        $this->entries = $items;
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
