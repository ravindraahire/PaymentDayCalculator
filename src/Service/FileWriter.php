<?php
declare(strict_types=1);

namespace PaymentCalculator\Service;

interface FileWriter
{
    public function write($data);
}