<?php
class PaymentDayCalculatorForMonth
{
	private $monthNumber;

	public function __construct($monthNumber = null)
	{
		if ($monthNumber) {
			$this->setMonthNumber($monthNumber);
		}
	}

	public function setMonthNumber($monthNumber)
	{
		$this->monthNumber = $monthNumber;
	}

	private function isValidMonthNumber()
	{
		$monthNumber = (int)$this->monthNumber;

		return ($monthNumber > 0 && $monthNumber < 13);
	}

	private function getFirstDay()
	{
		if (!$this->isValidMonthNumber()) {
			throw new \Exception('Please provide valid month number');
		}

		return DateTime::createFromFormat('!Y-m', date('Y') . '-' . $this->monthNumber);
	}

	public function getSalaryDate()
	{
		$date = $this->getFirstDay()->modify('last day of this month');

		$salaryDate = ($this->isWeekend($date)) ? $date->modify('last friday') : $date;	
		
		return $salaryDate->format('Y-m-d');
	}

	public function getBonusDate()
	{
		$date = $this->getFirstDay()->modify('+14 day');

		$bonusDate = ($this->isWeekend($date)) ? $date->modify('next wednesday') : $date;
		
		return $bonusDate->format('Y-m-d');
	}

	public function getPaymentMonth()
	{
		return $this->getFirstDay()->format('M');
	}

	private function isWeekend($date)
	{
		return in_array($date->format('l'), ['Saturday', 'Sunday']);
	}
}