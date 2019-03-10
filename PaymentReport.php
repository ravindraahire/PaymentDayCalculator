<?php
require('CsvFileWriter.php');

class PaymentReport
{
	private $file;

	private $paymentDayCalculatorForMonth;

	public function __construct($fileName)
	{
		$this->file = new SplFileObject($fileName, 'w+');
		$this->paymentDayCalculatorForMonth = new PaymentDayCalculatorForMonth();
	}

	public function generate()
	{
		$fileWriter = new CsvFileWriter($this->file);
		$fileWriter->write($this->preparePaymentData());

		return true;
	}
	
	private function preparePaymentData()
	{
		$iterator = new ArrayIterator();
		$iterator->append(['Payment month', 'Salary Date', 'Bonus Date']);
		for ($i = (int) (new DateTime())->format('m'); $i < 13; $i++) {
			$this->paymentDayCalculatorForMonth->setMonthNumber($i);
			$iterator->append([
				$this->paymentDayCalculatorForMonth->getPaymentMonth(),
				$this->paymentDayCalculatorForMonth->getSalaryDate(),
				$this->paymentDayCalculatorForMonth->getBonusDate(),
			]);
		}

		return $iterator;
	}
}