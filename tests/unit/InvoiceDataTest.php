<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Model\InvoiceData;
use \App\Model\PersonalInfo;
use \App\Model\BankData;
use \App\Model\ClientData;
use \App\Model\SummaryProjectData;
use \App\Model\Database;

final class InvoiceDataTest extends TestCase
{
    private $invoiceData;

    public function setUp(): void
    {
        $this->invoiceData = new InvoiceData(
            '2020-03-01',
            '2020-07-15',
            new PersonalInfo,
            new ClientData('db', 'Dummy'),
            new BankData,
            new SummaryProjectData('2020-03-01', '2020-07-15', 'Dummy')
        );
    }

    public function testCanCreateInvoiceDataCorrectly()
    {
        $this->assertNotEmpty($this->invoiceData);
    }

    public function testCanSaveInvoiceToDatabase()
    {
        $this->assertTrue($this->invoiceData->save(new Database));
    }

    public function testCanGetIdFromDatabase()
    {
        $id = $this->invoiceData->getId(new Database);
        $this->assertIsInt($id);
    }
    
    public function testCanConvertToPdf()
    {
        $this->invoiceData->setFilename('Invoice.docx');
        $this->assertSame(0, $this->invoiceData->convertToPdf());
    }
}
