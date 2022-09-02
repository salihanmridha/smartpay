<?php

namespace App\Http\Services;

use App\Models\FreeOfChargePayment;
use App\Models\PaymentRule;
use App\Models\CurrencyMinorUnit;

class CommonFeeCalculationQueryService
{
    public function getPaymentRuleByPaymentClientType(string $paymentType, string $clientType): PaymentRule
    {
      return PaymentRule::where("payment_type", $paymentType)
                        ->where("client_type", $clientType)
                        ->first();
    }


    public function getFreeLimit(PaymentRule $paymentRule, array $fileElement): float
    {
      $startEndWeekDay = startEndWeekDay($fileElement["payment_date"]);

      $getUserFreeOfChargePayment = FreeOfChargePayment::where("client_id", $fileElement["client_id"])
                                  ->whereBetween("payment_date", [$startEndWeekDay["week_first_day"], $startEndWeekDay["week_last_day"]])
                                  ->get();

      if ($getUserFreeOfChargePayment->count() > 0 ) {

        if ($getUserFreeOfChargePayment->count() == $paymentRule->free_of_charge) {
          return (float)0.00;
        }

        if ($getUserFreeOfChargePayment->sum('amount') >= $paymentRule->free_of_charge_amount) {
          return (float)0.00;
        }

        if ($getUserFreeOfChargePayment->sum('amount') < $paymentRule->free_of_charge_amount) {
          return (float) ($paymentRule->free_of_charge_amount - $getUserFreeOfChargePayment->sum('amount'));
        }
      }


      return (float)$paymentRule->free_of_charge_amount;
    }

    public function calculation(float $amount, float $chargeBy, string $currency)
    {
      $minorUnit = CurrencyMinorUnit::where("currency", $currency)->first();
      $commisionFee = ($amount * $chargeBy) / 100;
      if ($commisionFee < number_format($commisionFee, $minorUnit->minor_unit)) {
        return number_format($commisionFee, $minorUnit->minor_unit);
      }

      return number_format((round($commisionFee / 0.05, 0)) * 0.05, $minorUnit->minor_unit);

    }
}
