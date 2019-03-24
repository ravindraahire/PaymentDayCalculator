<?php
declare(strict_types=1);

namespace PaymentCalculator\Service;

use DateTime;
use Exception;

class PaymentDayCalculatorForMonth
{
	/** @var DateTime */
	private $monthFirstDay;

	/**
	 * @param int|null $monthNumber
	 * @param int|null $year
	 * @throws Exception
	 */
	public function __construct(int $monthNumber = null, int $year = null)
	{
		$currentDate = new DateTime();
		$year = $year ?? $currentDate->format('Y');
		$monthNumber = $monthNumber ?? $currentDate->format('m');

		if (!(in_array($monthNumber, range(1,12)) && $monthFirstDay = DateTime::createFromFormat('Y-m-d', $year . '-' . $monthNumber . '-01'))) {
			throw new Exception('Please provide valid year and month');
		}

		$this->monthFirstDay = $monthFirstDay;
	}

	/**
	 * @return DateTime
	 */
	public function getMonthFirstDay(): DateTime
	{
		return new DateTime($this->monthFirstDay->format('Y-m-d'));
	}

	/**
	 * @return string
	 */
	public function getSalaryDate(): string
	{
		$lastDayOfMonth = $this->getMonthFirstDay()->modify('last day of this month');

		$salaryDate = ($this->isWeekend($lastDayOfMonth)) ?
			$lastDayOfMonth->modify('last friday') : $lastDayOfMonth;
		
		return $salaryDate->format('Y-m-d');
	}

	/**
	 * @return string
	 */
	public function getBonusDate(): string
	{
		$forteenthDayOfMonth = $this->getMonthFirstDay()->modify('+14 day');

		$bonusDate = ($this->isWeekend($forteenthDayOfMonth)) ?
			$forteenthDayOfMonth->modify('next wednesday') : $forteenthDayOfMonth;
		
		return $bonusDate->format('Y-m-d');
	}

	/**
	 * @return string
	 */
	public function getPaymentMonth(): string
	{
		return $this->getMonthFirstDay()->format('M');
	}

	/**
	 * @param DateTime $date
	 * @return bool
	 */
	private function isWeekend(DateTime $date): bool
	{
		return in_array($date->format('l'), ['Saturday', 'Sunday']);
	}
}