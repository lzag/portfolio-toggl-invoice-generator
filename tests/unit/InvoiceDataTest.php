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

    public function testCanSaveInvoiceToDatabase()
    {
        $invoiceData = new InvoiceData('2020-05-07', '2020-12-08', 'Dummy');
        $this->assertTrue($invoiceData->save());
    }

    public function testCanGetIdFromDatabase()
    {
        $invoiceData = new InvoiceData('2020-05-07', '2020-12-08', 'Dummy');
        $id = $invoiceData->getId();
        $this->assertIsInt($id);
    }
    
    public function testCanConvertToPdf()
    {
        $invoiceData = new InvoiceData('2020-05-07', '2020-12-08', 'Dummy');
        $invoiceData->setFilename('Invoice.docx');
        $this->assertSame(0, $invoiceData->convertToPdf());
    }
}
