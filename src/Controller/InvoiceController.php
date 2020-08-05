<?php
namespace App\Controller;

use \PhpOffice\PhpWord\TemplateProcessor;
use \App\Model\InvoiceData;

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

    public function new($start_date, $end_date, $customer, $invoice_date = '')
    {
        return $this->view(
            'invoice/new',
            [
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'customer'   => $customer,
            ]
        );
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
