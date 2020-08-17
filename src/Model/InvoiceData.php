<?php
namespace App\Model;

use App\Model\ClientData;
use App\Model\Database;
use App\Model\SummaryProjectData;
use App\Model\PersonalInfo;
use App\Model\BankData;

class InvoiceData
{

    private $my_data;

    private $invoice_date;

    private $client_data;

    private $projects_summary;

    private $bank_data;

    private $filename;

    private $db;
    
    private $rate;

    public function __construct(
        $invoice_date,
        $invoice_due,
        PersonalInfo $my_data,
        ClientData $client_data,
        BankData $bank_data,
        SummaryProjectData $projects_summary,
        $rate = '10.00'
    ) {
        $this->client_data = $client_data;
        $this->bank_data = $bank_data;
        $this->my_data = $my_data;
        $this->projects_summary = $projects_summary;
        $this->rate = $rate;

        if ($invoice_date === '') {
            $date = new \DateTime();
            $this->invoice_date = $date->format('Y/m/d');
            $this->invoice_due = $date->add(new \DateInterval('P30D'))->format('Y/m/d');
        } else {
            $this->invoice_date = \DateTime::createFromFormat('Y-m-d', $invoice_date)->format('Y/m/d');
            $this->invoice_due = \DateTime::createFromFormat('Y-m-d', $invoice_due)->format('Y/m/d');
        }
    }

    public function save(Database $db)
    {
        $db->connect();
        $conn = $db->getConn();

        $start_date = $this->projects_summary->getStartDate();
        $end_date = $this->projects_summary->getEndDate();

        $sql = "INSERT INTO invoices (start_date, end_date, invoice_date, invoice_due, client_name, filename) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $start_date,
            $end_date,
            $this->invoice_date,
            $this->invoice_due,
            $this->client_data->getCompanyName(),
            $this->filename,
            ]);
        return $conn->lastInsertId();
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

    public function getId(Database $db)
    {
        $db->connect();
        $conn = $db->getConn();
        $sql = "
                SELECT AUTO_INCREMENT as id
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = 'demodb'
                AND   TABLE_NAME   = 'invoices';
                ";
        $id = $conn->query($sql)->fetchObject()->id;
        return $id;
    }

    public static function getAll(Database $db)
    {
        $db->connect();
        $conn = $db->getConn();
        $sql = "SELECT
                id,
                start_date,
                end_date,
                invoice_date,
                invoice_due,
                client_name,
                filename
                FROM
                invoices";
        return $conn->query($sql)->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function delete(Database $db, $id)
    {
        $id = (int) $id;
        if (filter_var($id, FILTER_SANITIZE_NUMBER_INT)) {
            $db->connect();
            $conn = $db->getConn();
            $sql = "DELETE FROM invoices
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            if ($stmt->rowCount()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getProjectsSummary()
    {
        return $this->projects_summary;
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

    public function getServiceRate()
    {
        return $this->rate;
    }
}
