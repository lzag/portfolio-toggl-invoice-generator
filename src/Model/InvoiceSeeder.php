<?php
namespace App\Model;

use \App\Model\Database;
use \Faker;
use \DateTime;

class InvoiceSeeder
{
    public function __construct()
    {
        return;
    }

    public static function clearDatabase()
    {
        return;
    }

    public static function seed(Database $db, $number)
    {
        $faker = \Faker\Factory::create();
        $options = [
            'options' => [
                'min_range' => 1,
                'max_range' => 100,
            ],
        ];
        if (filter_var($number, FILTER_VALIDATE_INT, $options)) {
            $db->connect();
            $conn = $db->getConn();

            $sql = "
                    INSERT INTO invoices
                    (start_date,
                    end_date,
                    invoice_date,
                    invoice_due,
                    client_name,
                    filename)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ";
            $stmt = $conn->prepare($sql);
            $records_inserted = 0;
            for ($i = 0; $i < $number; $i++) {
                $date = $faker->dateTimeThisYear();
                $invoice_date = $date->format('Y-m-d');

                // end date max $invoice date
                $min_date = $date->sub(new \DateInterval('P30D'))->format('Y-m-d');
                $services_date = $faker->dateTimeBetween($min_date, $date);
                $end_date = $services_date->format('Y-m-d');

                // start date minux 14 days from services
                $start_date = $services_date->sub(new \DateInterval('P14D'))->format('Y-m-d');

                // payment due plus 30 days from invoice
                $invoice_due = $date->add(new \DateInterval('P60D'))->format('Y-m-d');

                $invoice_id = $faker->numberBetween(1, $number);

                $result = $stmt->execute([
                    $start_date,
                    $end_date,
                    $invoice_date,
                    $invoice_due,
                    $faker->company,
                    INVOICES_DIR . '/' . 'Invoice_' . $invoice_id . '_' . $invoice_date . '.docx'
                ]);
                $records_inserted += $result ? 1 : 0;
            }
            echo "Inserted $records_inserted records in the database";
        } else {
            echo "Please enter a number between 1 and 100";
        }
        return $records_inserted;
    }
}
