<?php
require('FileWriter.php');

class CsvFileWriter implements FileWriter
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
        if($this->file->getExtension() !== 'csv') {
            throw new Exception('File should be of type csv');
        }
    }

    public function write($iterator)
    {
        foreach ($iterator as $value) {
            $this->file->fputcsv($value);
        }
    }
}