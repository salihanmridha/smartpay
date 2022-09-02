<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Contracts\FeeCalculatorInterface;

class PaymentController extends Controller
{
    private FeeCalculatorInterface $feeCalculator;

    public function __construct(FeeCalculatorInterface $feeCalculator)
    {
      $this->feeCalculator = $feeCalculator;
    }

    /**
     * @param  StorePaymentRequest $request
     * @return string
     */
    public function store(StorePaymentRequest $request)
    {
      return $this->feeCalculator->execute($request->file("file"));
    }
}
