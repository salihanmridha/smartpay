<?php

namespace App\Traits;

trait CurrencyConverter
{

  public function currencyConvert(string $currency): array
  {
    $callBackUrl = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
    $json = file_get_contents($callBackUrl);
    $jsonDecode = json_decode($json);
    return ["base" => $jsonDecode->base, "rate" => $jsonDecode->rates->$currency];
  }

}
