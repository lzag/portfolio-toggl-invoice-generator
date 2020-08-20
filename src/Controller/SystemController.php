<?php
namespace App\Controller;

use \App\Model\InvoiceSeeder;
use \App\Model\Database;

class SystemController extends BaseController
{
    public function setup()
    {
        echo "setting up";
        return "records created";
    }

    public function seed($no_records)
    {
        echo 'Seeding database';
        $created = InvoiceSeeder::seed(new Database, $no_records);
        $message = $created . ' record created.';
        echo $message;
        return "seeding  {$created} records finished";
    }
    
    public function clear()
    {
        InvoiceSeeder::clear();
    }
}
