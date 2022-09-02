<?php

namespace App\Repositories\Classes;

use App\Repositories\Contracts\PaymentRuleRepositoryInterface;
use App\Models\PaymentRule;

class PaymentRuleRepository implements PaymentRuleRepositoryInterface
{
    /**
     * PaymentRuleRepository constructor.
     */
    public function __construct(PaymentRule $paymentRule)
    {
        parent::__construct($paymentRule);
        $this->model = $paymentRule;
    }

}
