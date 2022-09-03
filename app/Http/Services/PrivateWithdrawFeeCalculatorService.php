<?php

namespace App\Http\Services;

use App\Http\Contracts\CommonFeeCalculatorInterface;
use App\Http\Contracts\PrivateWithdrawFeeCalculatorInterface;
use App\Models\FreeOfChargePayment;
use App\Models\PaymentRule;
use App\Traits\CurrencyConverter;


class PrivateWithdrawFeeCalculatorService extends CommonFeeCalculationQueryService implements CommonFeeCalculatorInterface, PrivateWithdrawFeeCalculatorInterface
{
    use CurrencyConverter;

    /**
     * @param  array $fileElement
     * @return mixed|int|float
     */
    public function feeCalculate(array $fileElement, array $crossRate = null): mixed
    {
      $paymentRule = $this->getPaymentRuleByPaymentClientType($fileElement["payment_type"], $fileElement["client_type"]);
      $getFreeLimit = $this->getFreeLimit($paymentRule, $fileElement);

      if ($getFreeLimit > 0.00) {
        $this->storeFreeOfChargePayment($fileElement, $getFreeLimit, $crossRate);
      }

      $getChargeAmount = 0.00;

      if ($crossRate && $crossRate["base"] && $crossRate["rate"]) {
        if ($fileElement["currency"] == $crossRate["base"]) {
          $getChargeAmount = ($getFreeLimit - $fileElement["amount"]) < 0 ? ($fileElement["amount"] - $getFreeLimit) : 0.00;
        }

        if ($fileElement["currency"] != $crossRate["base"]) {
          $amount = $fileElement["amount"] / $crossRate["rate"];
          $getChargeAmount = ($getFreeLimit - $amount) < 0 ? ($amount - $getFreeLimit) : 0.00;
          $getChargeAmount = $crossRate["rate"] * $getChargeAmount;
        }
      }


      return $this->calculation($getChargeAmount, $paymentRule->fee, $fileElement["currency"]);

    }

    /**
     * @param array $fileElement
     * @param float $getFreeLimit
     * @return void
     */
    public function storeFreeOfChargePayment(array $fileElement, float $getFreeLimit, array $crossRate = null): void
    {
      $usingLimit = 0.00;

      if ($crossRate && $crossRate["base"] && $crossRate["rate"]) {
        if ($fileElement["currency"] == $crossRate["base"]) {
          $usingLimit = ($getFreeLimit - $fileElement["amount"]) < 0 ? $getFreeLimit : $fileElement["amount"];
        }

        if ($fileElement["currency"] != $crossRate["base"]) {
          $amount = $fileElement["amount"] / $crossRate["rate"];
          $usingLimit = ($getFreeLimit - $amount) < 0 ? $getFreeLimit : $amount;
        }

        FreeOfChargePayment::create([
          "payment_date" => $fileElement["payment_date"],
          "client_id" => $fileElement["client_id"],
          "payment_type" => $fileElement["payment_type"],
          "amount" => $usingLimit,
          "currency" => $crossRate["base"],
        ]);
        
      }



    }

}
