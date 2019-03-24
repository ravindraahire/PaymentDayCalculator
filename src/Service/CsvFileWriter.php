<?php
declare(strict_types=1);

namespace PaymentCalculator\Service;

use Exception;
use SplFileObject;

class CsvFileWriter implements FileWriter
{
    /** @var SplFileObject */
    private $file;

    /**
     * @param SplFileObject $file
     * @throws Exception
     */
    public function __construct(SplFileObject $file)
    {
        $this->file = $file;
        if($this->file->getExtension() !== 'csv') {
            throw new Exception('File should be of type csv');
        }
    }

    /**
     * @param $iterator
     */
    public function write($iterator): void
    {
        foreach ($iterator as $value) {
            $this->file->fputcsv($value);
        }
    }
}