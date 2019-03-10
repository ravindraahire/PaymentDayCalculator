<?php
require('PaymentDayCalculatorForMonth.php');
require('PaymentReport.php');
require('vendor/autoload.php');

try {
	$fileName = isset($argv[1]) ? $argv[1] : '';
	if (!$fileName) {
		throw new Exception('Please provide file name');
	}
	if (pathinfo($fileName, PATHINFO_EXTENSION) !== 'csv') {
		throw new Exception('File should be of csv type');
	}
	//echo Mockery::class;echo Mockery\Adapter\Phpunit\MockeryTestCase::class;var_dump(new NamedMockTest());exit;
	$paymentReport = new PaymentReport($fileName);
	$reportGenerated = $paymentReport->generate();
	if ($reportGenerated) {
		echo 'Payment report generated successfully.';
	}
} catch(\Exception $e) {
	echo $e->getMessage();exit;
}