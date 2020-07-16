<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Model\InvoiceData;

final class InvoiceDataTest extends TestCase
{
    public function testCanCreateInvoiceDataCorrectly()
    {
        $invoiceData = new InvoiceData('2020-05-07', '2020-12-08', 'Dummy');
        $this->assertNotEmpty($invoiceData);
    }
}
