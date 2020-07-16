<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use \App\Controller\InvoiceController;
use \App\Model\InvoiceData;

final class InvoiceControllerTest extends TestCase
{
    public function testCanCreateInvoiceFromTemplate()
    {
        $invoiceController = new InvoiceController();
        $result = $invoiceController->create(new InvoiceData(
            '2020-03-01',
            '2020-07-15',
            'Dummy'
        ));
        $this->assertTrue($result);
    }
}
