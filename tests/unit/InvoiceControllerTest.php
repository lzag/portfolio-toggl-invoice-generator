<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use \App\Controller\InvoiceController;
use \App\Model\InvoiceData;
use \App\Model\PersonalInfo;
use \App\Model\BankData;
use \App\Model\ClientData;
use \App\Model\SummaryProjectData;

final class InvoiceControllerTest extends TestCase
{
    public function testCanCreateInvoiceFromTemplate()
    {
        $invoiceController = new InvoiceController();

        $result = $invoiceController->create(new InvoiceData(
            '2020-03-01',
            '2020-07-15',
            new PersonalInfo,
            new ClientData('db', 'Dummy'),
            new BankData,
            new SummaryProjectData('2020-03-01', '2020-07-15', 'Dummy')
        ));
        $this->assertIsString($result);
    }
}
