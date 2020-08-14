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

    public function __construct(
        $invoice_date,
        $invoice_due,
        $my_data,
        $client_data,
        $bank_data,
        $projects
    ) {
        $this->client_data = $client_data;
        $this->bank_data = $bank_data;
        $this->my_data = $my_data;
        $this->projects = $projects;
        $this->start_date = '';
        $this->end_date = '';

        if ($invoice_date === '') {
            $date = new \DateTime();
            $this->invoice_date = $date->format('Y/m/d');
            $this->invoice_due = $date->add(new \DateInterval('P30D'))->format('Y/m/d');
        } else {
            $this->invoice_date = \DateTime::createFromFormat('Y-m-d', $invoice_date)->format('Y/m/d');
            $this->invoice_due = \DateTime::createFromFormat('Y-m-d', $invoice_due)->format('Y/m/d');
        }
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

    public function getProjects()
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
