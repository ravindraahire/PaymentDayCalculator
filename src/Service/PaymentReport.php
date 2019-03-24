<?php
declare(strict_types=1);

namespace PaymentCalculator\Service;

use ArrayIterator;
use DateTime;
use SplFileObject;

class PaymentReport
{
	/** @var SplFileObject */
	private $file;

	/**
	 * @param string $fileName
	 */
	public function __construct(string $fileName)
	{
		$this->file = new SplFileObject($fileName, 'w+');
	}

	/**
	 * @return bool
	 */
	public function generate(): bool
	{
		$fileWriter = new CsvFileWriter($this->file);
		$fileWriter->write($this->preparePaymentData());

		return true;
	}

	/**
	 * @return ArrayIterator
	 */
	private function preparePaymentData(): ArrayIterator
	{
		$iterator = new ArrayIterator();
		$iterator->append(['Payment month', 'Salary Date', 'Bonus Date']);
		for ($i = (int) (new DateTime())->format('m'); $i < 13; $i++) {
			$paymentDayCalculatorForMonth = new PaymentDayCalculatorForMonth($i);
			$iterator->append([
				$paymentDayCalculatorForMonth->getPaymentMonth(),
				$paymentDayCalculatorForMonth->getSalaryDate(),
				$paymentDayCalculatorForMonth->getBonusDate(),
			]);
		}

		return $iterator;
	}
}