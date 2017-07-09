<?php
 
namespace App\Repositories\Payment;
 
interface PaymentRepositoryInterface
{
    public function action(Request $request);
}