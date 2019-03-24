<?php
declare(strict_types=1);

namespace PaymentCalculatorTest\Service;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use PaymentCalculator\Service\CsvFileWriter;
use PaymentCalculator\Service\PaymentReport;
use SplFileObject;
use Mockery as M;
use Mockery\MockInterface;

class PaymentReportTest extends MockeryTestCase
{
    /** @var PaymentReport */
    private $paymentReport;

    public function setUp()
    {
        $this->paymentReport = new PaymentReport('tests/createPaymentReportForTest.csv');
    }

    public function testGenerate(): void
    {
        $result = $this->paymentReport->generate();
        $file = new SplFileObject('tests/createPaymentReportForTest.csv', 'r');

        $this->assertContains('Payment month', $file->fgetcsv());
        $this->assertTrue($result);
    }

    public function tearDown()
    {
        unlink('tests/createPaymentReportForTest.csv');
    }
}