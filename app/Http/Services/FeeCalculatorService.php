<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeCalculatorInterface;
use App\Http\Contracts\FileParsingInterface;

class FeeCalculatorService extends CommonFeeCalculationQueryService implements FeeCalculatorInterface
{
    private FileParsingInterface $fileParsing;
    public array $result;
    public array $crossRate;

    public function __construct(FileParsingInterface $fileParsing)
    {
      $this->fileParsing = $fileParsing;
      $this->result = [];
      $this->crossRate = [];
    }

    public function execute(mixed $file): array
    {
      $fileParsing = $this->fileParsing->fileParser($file);

      foreach ($fileParsing as $fileElement) {
        $fullClassName = 'App\\Http\\Services\\' . ucfirst($fileElement["payment_type"]) . "FeeCalculatorService";

        $crossRate = $this->getCrossRate($fileElement["currency"]);

        if (class_exists($fullClassName)) {
            $commisionFee = (new $fullClassName())->feeCalculate($fileElement, $crossRate);
            array_push($this->result, $commisionFee);
        } else {
            throw new \Exception('CSV file has invalid payment type: ' . $fullClassName);
        }
      }

      return $this->result;
    }

}
