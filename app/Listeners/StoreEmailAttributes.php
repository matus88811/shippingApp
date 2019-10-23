<?php

namespace App\Listeners;

use App\Events\EmailReceived;
use App\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreEmailAttributes
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
     * @param  EmailReceived  $event
     * @return void
     */
    public function handle(EmailReceived $event)
    {
        $food = [
            'restaurant',
            'cafeteria',
            'kitchen',
            'eatery',
            'cafe',
            'bistro',
            'fast food',
            'lunch',
            'cuisine',
            'bufet',
            'buffet',
            'canteen',
            'bar',
            'steakhouse',
            'tearoom',
            'coffee shop',
            'pub',
            'lunchroom',
            'alcoholic beverage',
            'breakfast',
            'beer',
            'wine',
            'grill',
            'food',
            'grillroom',
            'eating place',
            'eating house',
            'coffeehouse',
            'steak',
            'chophouse',
        ];

        // tu by som mohol davat dalsie polia a  podla podmienok porovnavat ci sa slovo nachadza v array 


        $payment_info = $event->attributesFromEmail; // vytiahneme si data 

        $keyword = trim(strstr(strtolower($payment_info['note']), ';', true)); // beriem prve slovo podla struktury ktore je klucove pre rozhodovanie aku kategoriu pridelit , kde predpokladame ze je to presne v takom formate, kedy sa hodnoty oddaluju s ;
        if(in_array($keyword, $food)) {
        $category = 'Food and Drink';
        } else {
            $category = 'Unspecialized';
        }

        // ulozenie dat z emailu do databazy
        Payment::create([ 
            'from' => trim($payment_info['from']),
            'to' => trim($payment_info['to']),
            'price' => trim($payment_info['price']),
            'date' => trim($payment_info['date']),
            'KS' => trim($payment_info['ks']),
            'VS' => trim($payment_info['vs']),
            'SS' => trim($payment_info['ss']),
            'Category' => $category
        ]);
    }
}
