<?php
declare(strict_types=1);

namespace PaymentCalculatorTest\Service;

use ArrayIterator;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PaymentCalculator\Service\CsvFileWriter;
use SplFileObject;
use Mockery as M;
use Mockery\MockInterface;

class CsvFileWriterTest extends MockeryTestCase
{
    /** @var SplFileObject */
    private $file;

    /** @var CsvFileWriter */
    private $csvFileWriter;

    public function setUp()
    {
        $this->file = new SplFileObject('tests/csvFileWriterForTest.csv', 'w+');
        $this->csvFileWriter = new CsvFileWriter($this->file);
    }

    public function testWrite(): void
    {
        $dataToWrite = [['test1', 'test2'], ['test3', 'test4']];
        $this->csvFileWriter->write(new ArrayIterator($dataToWrite));

        $this->assertEquals($this->file->openFile()->fgetcsv(), $dataToWrite[0]);
    }
    
    public function tearDown()
    {
        unlink($this->file->getRealPath());
        $this->file = null;
        unset($this->file);
    }
}