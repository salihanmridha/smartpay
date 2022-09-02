<?php

namespace App\Http\Services;

use App\Http\Contracts\CommonFeeCalculatorInterface;

class DepositFeeCalculatorService implements CommonFeeCalculatorInterface
{
    /**
     * @param  array $fileElement
     * @return mixed|int|float
     */
    public function feeCalculate(array $fileElement): mixed
    {
      $fullClassName = 'App\\Http\\Services\\' . ucfirst($fileElement["client_type"]) . ucfirst($fileElement["payment_type"]) . "FeeCalculatorService";

      if (class_exists($fullClassName)) {
          return (new $fullClassName())->feeCalculate($fileElement);
      } else {
          throw new \Exception('CSV file has invalid client with payment type: ' . $fullClassName);
      }
    }

}
