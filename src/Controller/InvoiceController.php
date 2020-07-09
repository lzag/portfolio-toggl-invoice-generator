<?php
namespace App\Controller;

use \PhpOffice\PhpWord\TemplateProcessor;

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
     * @return bool
     */
    public function create(): bool
    {
        $me = 'Test file';
        $invoice_file = $this->invoice_path . 'Invoice.docx';
        $templateProcessor = new TemplateProcessor('/home/lukasz/projects/invoice-generator/invoice_templates/Invoice_template.docx');
        $templateProcessor->setValue('my-name', $me);
        $return = $templateProcessor->saveAs($invoice_file);
        if (file_exists($invoice_file)) {
            return true;
        } else {
            return false;
        }
    }
}
