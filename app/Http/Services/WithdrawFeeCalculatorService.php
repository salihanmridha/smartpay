<?php

namespace App\Http\Services;

use App\Http\Contracts\CommonFeeCalculatorInterface;
use Exception;

class WithdrawFeeCalculatorService implements CommonFeeCalculatorInterface
{
    /**
     * @param  array $fileElement
     * @return mixed|int|float
     */
    public function feeCalculate(array $fileElement, array $crossRate = null): mixed
    {
      $fullClassName = 'App\\Http\\Services\\' . ucfirst($fileElement["client_type"]) . ucfirst($fileElement["payment_type"]) . "FeeCalculatorService";

      if (class_exists($fullClassName)) {
          return (new $fullClassName())->feeCalculate($fileElement, $crossRate);
      } else {
          throw new Exception('CSV file has invalid client with payment type: ' . $fullClassName);
      }
    }

}
