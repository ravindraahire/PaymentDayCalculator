<?php
declare(strict_types=1);

namespace PaymentCalculatorTest\Service;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use PaymentCalculator\Service\PaymentDayCalculatorForMonth;

class PaymentDayCalculatorForMonthTest extends MockeryTestCase
{
    /**
     * @dataProvider PaymentDayCalculatorDataProvider
     */
    public function testPaymentDayCalculator($monthNumber, $year, $expectedSalaryDate, $expectedBonusDate, $expectedPaymentMonth)
    {
        $paymentDayCalculatorForMonth = new PaymentDayCalculatorForMonth($monthNumber, $year);
        $salaryDate = $paymentDayCalculatorForMonth->getSalaryDate();
        $bonusDate = $paymentDayCalculatorForMonth->getBonusDate();
        $paymentMonth = $paymentDayCalculatorForMonth->getPaymentMonth();

        $this->assertEquals($expectedSalaryDate, $salaryDate);
        $this->assertEquals($expectedBonusDate, $bonusDate);
        $this->assertEquals($expectedPaymentMonth, $paymentMonth);
    }

    /**
     * @return array
     */
    public function PaymentDayCalculatorDataProvider(): array
    {
        return [
            [3, 2019, '2019-03-29', '2019-03-15', 'Mar'],
        ];
    }

    /**
     * @expectedException \Exception
     */
    public function testPaymentDayCalculatorInvalidDate()
    {
        $paymentDayCalculatorForMonth = new PaymentDayCalculatorForMonth(13, 2019);
    }
}