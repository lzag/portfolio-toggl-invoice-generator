<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Model\ProjectData;

final class ProjectDataTest extends TestCase
{
    public function testCanObtainProjectData()
    {
        $title = 'Testing API';
        $hours = 4;
        $entries = [
            'first entry',
            'second entry',
        ];
        $projectData = new ProjectData($title, $hours, $entries);
        $this->assertSame(2, count($projectData->getEntries()));
        $this->assertSame('Testing API', $projectData->getTitle());
        $this->assertSame(4, $projectData->getTotalHours());
        $this->assertSame('second entry', $projectData->getEntries()[1]);
    }
}
