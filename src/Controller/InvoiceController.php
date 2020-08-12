<?php
namespace App\Controller;

use \PhpOffice\PhpWord\TemplateProcessor;
use \App\Model\InvoiceData;
use \App\Model\ClientData;
use \App\Model\PersonalInfo;
use \App\Model\BankData;

class InvoiceController extends BaseController
{
    /*
     * @param string
     */
    private $template_path = 'invoice_templates/Invoice_template.docx';

    /*
     * @param string
     */
    private $invoice_path = 'invoices/';

    /*
     * Constructor function
     *
     * Assigns the correct configuration parameters
     */
    public function __construct()
    {
        // $this->template_path  = config('invoice.template_path');
    }

    /*
     * Creates a new invoice
     *
     * @param InvoiceData
     * @return bool
     */
    public function create(InvoiceData $invoiceData): bool
    {
        $templateProcessor = new TemplateProcessor(PROJECT_DIR . '/invoice_templates/Invoice_template.docx');

        // fill in  my information section
        $templateProcessor->setValue('my_name', $invoiceData->getMyData()->getMyName());
        $templateProcessor->setValue('my_phone', $invoiceData->getMyData()->getMyPhone());
        $templateProcessor->setValue('my_email', $invoiceData->getMyData()->getMyEmail());
        $templateProcessor->setValue('my_address1', $invoiceData->getMyData()->getMyAddress1());
        $templateProcessor->setValue('my_address2', $invoiceData->getMyData()->getMyAddress2());

        // fill in client data
        $templateProcessor->setValue('company_name', $invoiceData->getClientData()->getCompanyName());
        $templateProcessor->setValue('company_address', $invoiceData->getClientData()->getFormattedAddress());
        $templateProcessor->setValue('company_country', $invoiceData->getClientData()->getCompanyCountry());
        $templateProcessor->setValue('contact_name', $invoiceData->getClientData()->getContactName());
        $templateProcessor->setValue('contact_email', $invoiceData->getClientData()->getContactEmail());

        // invoice data section
        $invoice_id = $invoiceData->getId();
        $templateProcessor->setValue('invoice_no', sprintf('%04d', $invoice_id));
        $templateProcessor->setValue('invoice_date', $invoiceData->getInvoiceDate());
        $templateProcessor->setValue('invoice_due', $invoiceData->getInvoiceDue());
        $templateProcessor->setValue('start_date', $invoiceData->getStartDate());
        $templateProcessor->setValue('end_date', $invoiceData->getEndDate());

        $projects = $invoiceData->getSummaryProjects()->getProjects();
        $projectValues = [];
        $subtotal = 0;
        $service_rate = 13.40;
        foreach ($projects as $project) {
            $total_hours = $project->getTotalHours();
            $projectValues[] = [
                'service_title'       => $project->getTitle(),
                'service_description' => $project->getEntriesWithLineBreaks(),
                'service_hours'       => $total_hours,
                'service_currency'    => 'CAD',
                'service_rate'        => number_format($service_rate, 2),
                'service_amount'      => number_format($service_rate * $total_hours, 2),
            ];
            $subtotal += $service_rate * $total_hours;
        }
        $templateProcessor->cloneRowAndSetValues('service_title', $projectValues);
        
        // calculate total value
        $tax_rate = 0;
        $tax_total = $tax_rate * $subtotal;
        $service_total = $tax_total + $subtotal;
        $service_currency = 'CAD';

        $templateProcessor->setValue('service_subtotal', number_format($subtotal, 2));
        $templateProcessor->setValue('service_currency', $service_currency);
        $templateProcessor->setValue('tax_total', number_format($tax_total, 2));
        $templateProcessor->setValue('service_total', number_format($service_total, 2));

        // bank data
        $templateProcessor->setValue('bank_data', $invoiceData->getBankData()->getAccountNumber());

        $invoice_date = \DateTime::createFromFormat('Y/m/d', $invoiceData->getInvoiceDate());
        $invoice_date = $invoice_date->format('Y_m_d');
        $invoice_file = $this->invoice_path . 'Invoice_' . $invoice_id . '_' . $invoice_date . '.docx';
        $return = $templateProcessor->saveAs($invoice_file);
        if (file_exists($invoice_file)) {
            return true;
        } else {
            return false;
        }
    }

    public function createFromForm($data)
    {
        $info = json_decode($data);
        var_dump($info);
    }

    public function new()
    {
        return $this->view(
            'invoice/new',
        );
    }

    public function fetchClientData($client)
    {
        $client_data = new ClientData($client);
        $smarty = new \Smarty();

        $smarty->assign('company_name', $client_data->getCompanyName());
        $smarty->assign('contact_name', $client_data->getContactName());
        $smarty->assign('contact_email', $client_data->getContactEmail());
        $smarty->assign('company_country', $client_data->getCompanyCountry());
        $smarty->assign('company_address', $client_data->getCompanyAddress());

        return $smarty->display(PROJECT_DIR . '/templates/invoice/clientInfo.tpl');
    }

    public function fetchMyData()
    {
        $my_data = new PersonalInfo;
        $smarty = new \Smarty;

        $smarty->assign('my_name', $my_data->getMyName());
        $smarty->assign('my_phone', $my_data->getMyPhone());
        $smarty->assign('my_email', $my_data->getMyEmail());
        $smarty->assign('my_address1', $my_data->getMyAddress1());
        $smarty->assign('my_address2', $my_data->getMyAddress2());

        return $smarty->display(PROJECT_DIR . '/templates/invoice/personalInfo.tpl');
    }
    public function fetchBankData()
    {
        $smarty = new \Smarty;
        $bank_data = new BankData;

        $smarty->assign('account_number', $bank_data->getAccountNumber());

        return $smarty->display(PROJECT_DIR . '/templates/invoice/bankInfo.tpl');
    }

    public function fetchServices($start_date, $end_date, $client)
    {
        $invData = new InvoiceData($start_date, $end_date, $client);
        $summaryProjects = $invData->getSummaryProjects();
        $smarty = new \Smarty();
        $smarty->assign('start_date', $start_date);
        $smarty->assign('end_date', $end_date);
        $smarty->assign('client', $client);
        $smarty->assign('total_hours', $summaryProjects->getTotalHours());
        $smarty->assign('projects', $summaryProjects->getProjects());
        return $smarty->display(PROJECT_DIR . '/templates/invoice/services.tpl');
    }

    public function edit($data)
    {
        $start_date = '01-05-2020';
        $end_date = '01-05-2020';
        $client = 'Dummy';
        $invoice_date = time();
        $inv = new InvoiceData(
            $start_date,
            $end_date,
            $client,
            $invoice_date
        );
        $data = [
            'invoice_date' => time(),
        ];
        return $this->view(
            'invoice/edit',
            [
            'title'        => 'Invoice Edit',
            'invoice_data' => $data
            ]
        );
    }
}
