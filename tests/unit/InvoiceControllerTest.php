<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use \App\Controller\InvoiceController;

final class InventoryControllerTest extends TestCase
{
    public function testCanCreateInvoiceFromTemplate()
    {
        $invoiceController = new InvoiceController();
        $result = $invoiceController->create();
        $this->assertTrue($result);
    }
}
