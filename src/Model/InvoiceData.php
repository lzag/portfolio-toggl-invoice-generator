<?php
namespace App\Model;

use App\Model\ClientData;
use App\Model\Database;

class InvoiceData
{

    private $my_data;

    private $invoice_date;

    private $client_data;

    private $projects;

    private $bank_data;

    private $filename;

    private $db;

    public function __construct($start_date, $end_date, $client, $invoice_date = '')
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $this->client_data = new ClientData($client);
        $this->bank_data = new BankData;
        $this->my_data = new PersonalInfo;
        $this->projects = $this->getSummaryProjectData($start_date, $end_date, $client);

        if ($invoice_date === '') {
            $date = new \DateTime();
            $this->invoice_date = $date->format('Y/m/d');
            $this->invoice_due = $date->add(new \DateInterval('P30D'))->format('Y/m/d');
        }
    }

    private function getSummaryProjectData($start_date, $end_date, $client)
    {
        return new SummaryProjectData(
            new TogglApi,
            $start_date,
            $end_date,
            $client
        );
    }

    public function save()
    {
        $db = new Database();
        $db->connect();
        $conn = $db->getConn();
        $sql = "INSERT INTO invoices (start_date, end_date, invoice_date, invoice_due) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $this->start_date,
            $this->end_date,
            $this->invoice_date,
            $this->invoice_due,
            ]);
        return true;
    }

    public function setFilename($name)
    {
        return $this->filename = $name;
    }

    public function convertToPdf()
    {
        $command = "libreoffice --headless --convert-to pdf invoices/$this->filename --outdir  invoices";
        exec(
            $command,
            $output,
            $return_var
        );
        return $return_var;
    }

    public function getId()
    {
        $db = new Database();
        $db->connect();
        $conn = $db->getConn();
        $sql = "SELECT MAX(id) AS id FROM invoices";
        $id = $conn->query($sql)->fetchObject()->id;
        return $id + 1;
    }

    public function getSummaryProjects()
    {
        return $this->projects;
    }

    public function getBankData()
    {
        return $this->bank_data;
    }

    public function getMyData()
    {
        return $this->my_data;
    }

    public function getClientData()
    {
        return $this->client_data;
    }

    public function getInvoiceDate()
    {
        return $this->invoice_date;
    }

    public function getInvoiceDue()
    {
        return $this->invoice_due;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }
}
