<?php
namespace App\Controller;

use \PhpOffice\PhpWord\TemplateProcessor;
use \App\Model\InvoiceData;
use \App\Model\ClientData;
use \App\Model\PersonalInfo;
use \App\Model\BankData;
use \App\Model\TogglApi;
use \App\Model\SummaryProjectData;
use \App\Model\ProjectData;
use \App\Model\Database;

class InvoiceController extends BaseController
{
    /*
     * @param string
     */
    private $template_path = 'invoice_templates/Invoice_template.docx';

    /*
     * @param string
     */
    private $invoice_path = PROJECT_DIR . '/invoices/';

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
    public function create(InvoiceData $invoiceData)
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
        $invoice_id = $invoiceData->getId(new Database);
        $templateProcessor->setValue('invoice_no', sprintf('%04d', $invoice_id));
        $templateProcessor->setValue('invoice_date', $invoiceData->getInvoiceDate());
        $templateProcessor->setValue('invoice_due', $invoiceData->getInvoiceDue());
        $templateProcessor->setValue('start_date', $invoiceData->getProjectsSummary()->getStartDate());
        $templateProcessor->setValue('end_date', $invoiceData->getProjectsSummary()->getEndDate());

        $projects = $invoiceData->getProjectsSummary()->getProjects();
        $projectValues = [];
        $subtotal = 0;
        $service_rate = $invoiceData->getServiceRate();
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
        $templateProcessor->setValue('account_number', 'Acc number: ' . $invoiceData->getBankData()->getAccountNumber());
        $templateProcessor->setValue('transit_number', 'Transit number: ' . $invoiceData->getBankData()->getTransitNumber());
        $templateProcessor->setValue('institution_number', 'Institution number: ' . $invoiceData->getBankData()->getInstitutionNumber());
        $templateProcessor->setValue('swift', 'Swift: ' . $invoiceData->getBankData()->getSwift());

        $invoice_date = \DateTime::createFromFormat('Y/m/d', $invoiceData->getInvoiceDate())->format('Y_m_d');
        $invoice_file = $this->invoice_path . 'Invoice_' . $invoice_id . '_' . $invoice_date . '.docx';
        $return = $templateProcessor->saveAs($invoice_file);
        if (file_exists($invoice_file)) {
            $invoiceData->setFilename(basename($invoice_file));
            $dbid = $invoiceData->save(new Database);
            return $dbid;
        } else {
            return false;
        }
    }

    public function createFromForm(string $data)
    {
        $form_data = json_decode($data);

        $bank_data = new BankData(
            'new',
            $form_data->entity_name,
            $form_data->account_number,
            $form_data->transit_number,
            $form_data->institution_number,
            $form_data->swift,
        );

        $company_address = [$form_data->company_address1, $form_data->company_address2, $form_data->company_address3];

        $client_data = new ClientData(
            'new',
            $form_data->company_name,
            $form_data->company_country,
            $company_address,
            $form_data->contact_name,
            $form_data->contact_email
        );

        $my_data = new PersonalInfo(
            'new',
            $form_data->my_name,
            $form_data->my_email,
            $form_data->my_phone,
            $form_data->my_address1,
            $form_data->my_address2,
        );

        $projects = new SummaryProjectData($form_data->fromDate, $form_data->toDate, $form_data->company_name);
        $projects->addProjects($form_data->projectList);

        $invoiceData = new InvoiceData(
            $form_data->invoice_date,
            $form_data->invoice_due,
            $my_data,
            $client_data,
            $bank_data,
            $projects,
            $form_data->rate
        );

        $id = $this->create($invoiceData);
        return print('Invoice no. ' . $id . ' generated');
    }

    public function new()
    {
        $date = new \DateTime();
        $invoice_date = $date->format('Y-m-d');
        $invoice_due = $date->add(new \DateInterval('P30D'))->format('Y-m-d');

        return $this->view(
            'invoice/new',
            [
            'invoice_date' => $invoice_date,
            'invoice_due' => $invoice_due,
            ]
        );
    }

    public function fetchClientData($client)
    {
        $client_data = new ClientData('db', $client);
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

        $smarty->assign('entity_name', $bank_data->getEntityName());
        $smarty->assign('account_number', $bank_data->getAccountNumber());
        $smarty->assign('institution_number', $bank_data->getInstitutionNumber());
        $smarty->assign('transit_number', $bank_data->getTransitNumber());
        $smarty->assign('swift', $bank_data->getSwift());

        return $smarty->display(PROJECT_DIR . '/templates/invoice/bankInfo.tpl');
    }

    public function fetchServices($start_date, $end_date, $client)
    {
        $summaryProjects = new SummaryProjectData($start_date, $end_date, $client);
        $summaryProjects->fetchProjects(new TogglApi);
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
