<?php
namespace App\Controller;

use \PhpOffice\PhpWord\TemplateProcessor;
use \App\Model\InvoiceData;

class InvoiceController
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
        $me = 'Test file';
        $invoice_file = $this->invoice_path . 'Invoice.docx';
        $templateProcessor = new TemplateProcessor(PROJECT_DIR . '/invoice_templates/Invoice_template.docx');

        // fill in  my information section
        $templateProcessor->setValue('my_name', $invoiceData->getMyData()->getMyName());
        $templateProcessor->setValue('my_phone', $invoiceData->getMyData()->getMyPhone());
        $templateProcessor->setValue('my_email', $invoiceData->getMyData()->getMyEmail());
        $templateProcessor->setValue('my_address1', $invoiceData->getMyData()->getMyAddress1());
        $templateProcessor->setValue('my_address2', $invoiceData->getMyData()->getMyAddress2());

        // fill in client data
        $templateProcessor->setValue('company_name', $invoiceData->getClientData()->getCompanyName());
        $templateProcessor->setValue('company_address', $invoiceData->getClientData()->getCompanyAddress());
        $templateProcessor->setValue('company_country', $invoiceData->getClientData()->getCompanyCountry());
        $templateProcessor->setValue('contact_name', $invoiceData->getClientData()->getContactName());
        $templateProcessor->setValue('contact_email', $invoiceData->getClientData()->getContactEmail());

        // invoice data section
        $templateProcessor->setValue('invoice_date', $invoiceData->getInvoiceDate());
        $templateProcessor->setValue('invoice_due', $invoiceData->getInvoiceDue());
        $templateProcessor->setValue('start_date', $invoiceData->getStartDate());
        $templateProcessor->setValue('end_date', $invoiceData->getEndDate());

        $projects = $invoiceData->getSummaryProjects()->getProjects();
        $projectValues = [];
        foreach ($projects as $project) {
            $projectValues[] = [
                'service_title' => $project->getTitle(),
                'service_description' => $project->getEntriesWithLineBreaks(),
                'service_hours' => $project->getTotalHours(),
            ];
        }
        $templateProcessor->cloneRowAndSetValues('service_title', $projectValues);

        // bank data
        $templateProcessor->setValue('bank_data', $invoiceData->getBankData()->getAccountNumber());

        $return = $templateProcessor->saveAs($invoice_file);
        if (file_exists($invoice_file)) {
            return true;
        } else {
            return false;
        }
    }
}
