<?php
namespace App\Model;

use App\Model\ClientData;

class InvoiceData
{

    private $my_data;

    private $invoice_date;

    private $client_data;

    private $projects;

    private $bank_data;

    public function __construct($start_date, $end_date, $client, $invoice_date = '')
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $this->client_data = new ClientData($client);
        $this->bank_data = new BankData;
        $this->my_data = new PersonalInfo;
        $this->projects = $this->getSummaryProjectData($start_date, $end_date, $client);

        $date = new \DateTime();
        $this->invoice_date = $date->format('Y/m/d');
        $this->invoice_due = $date->add(new \DateInterval('P30D'))->format('Y/m/d');
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
