<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\PaymentSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPaymentEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendEmail  $event
     * @return void
     */
    public function handle(SendEmail $event)
    {
        $payment = $event->payment; // data ktore prisli z formulara 
        Mail::to('example@gmail.com')->send(// posielam email , na adresu ktoru zadam a posielam do mailu array s udajmi z formulara , ktore sa priradia cez konstruktor v mail classe a budu rovno dostupne v email template.
                new PaymentSent($payment) 
            );

        
    }
}
