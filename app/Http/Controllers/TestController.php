<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Events\EmailReceived;
use App\Events\SendEmail;
use App\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpImap\Mailbox as Mailbox;



class TestController extends Controller
{





    public function fetchEmail()
    {
	

$inbox = imap_open('{imap.gmail.com:993/imap/ssl}INBOX','email_which_you_want_to_fetch','google_app_password') or die('Cannot connect: ' . imap_last_error());
// napajam sa na konkretnu email adresu ktorej chcem fetchovat emaily

$emails = imap_search($inbox,'ALL');
// vytahujem vsetky , hlavne koli ich poctu a koli porovnavaniu kedy prisiel novy email



$currentEmails = DB::table('variables')->where('id', '=' , 1 )->get(); // vytvoril som si jednu pomocnou 'premennu' aby som si ukladal konkretny pocet emailov



$currentEmailCount = $currentEmails->implode('email_count'); // vytiahne sa najaktualnejsi pocet emailov ktory sa naposledy updatol pri dostati noveho emailu 

if($currentEmailCount == 0) { //  to sa vykona jak prve po prichode na homepage , potom sa stale bude vykonavat uz len druha podmienka , porovnavanie
	DB::table('variables')
            ->where('id', 1)
            ->update(['email_count' => count($emails)]);
} 


elseif ($currentEmailCount != count($emails)) { // ak sa stara hodnota naposledy ulozena ( pocet emailov) nerovna aktualnemu poctu emailov , znamena ze sme dostali novy email

 
$last_email = count($emails); // tuto si ulozime hodnotu posledneho emailu aby sme z tohto emailu mali message pre ulozenie do DB


     
        // tento kusok kodu je vybudovany konkretne pre strukturu html gmailu a s strukturou laravel templatu pre email ktory som si vytvoril a pridal klucove elementy podla ktorych vytvaram strukturu array
        // kde predpokladame ze email info o platbe bude prichadzat prave v takom formate ako je vo vasom zadani. nastavil som nato aj formular aj template emailu
        
        $message = imap_fetchbody($inbox, $last_email, 2); 
        $message = strstr($message, 'From'); // odstranim vsetok text pred from 
        $message = strstr($message, '<span style=3D', true); // v email template som si vyznacil koniec znenia a odseknem tento span vratane vsetkeho texu za nim
       
        
       $array = explode('<br>', $message); // v email template som si nastavil br ako pomocny prvok pre explode na array
      	
      $array_to_db = [];
      // vytvaram array do podoby v ktorom ho chcem mat pre ulozenie do databazy, vytvaram vlastne kluce, odstranujem klucove slova a priradzujem values
      $array_to_db['from'] = str_replace('From:', '', $array[0]);
      $array_to_db['to'] = str_replace('To:', '',$array[1]);
      $array_to_db['price'] = str_replace('Price:', '',$array[2]);
      $array_to_db['date'] = str_replace('Date:', '',$array[3]);
      $array_to_db['ks'] = str_replace('KS:', '',$array[4]);
      $array_to_db['vs'] = str_replace('VS:', '',$array[5]);
      $array_to_db['ss'] = str_replace('SS:', '',$array[6]);
      $array_to_db['note'] = str_replace('Note:', '',$array[7]);

		DB::table('variables')
            ->where('id', 1)
            ->update(['email_count' => count($emails)]); 
// vzdy ked sa tato podmienka splni v ktorej sme, tak sa nam updatne pocet emailov na aktualny
            
            event(new EmailReceived($array_to_db));

            // odpaluje sa event ktory ocakava kedy pride email do mailboxu
            // do eventu posielam ten array a tam sa uz upravia veci a ukladanie do db sa poriesi tam
           
    	 }

    	 return view('welcome');
    
    }

    public function sendPayment()
    {
    	$banks = DB::table('banks')->get(); // vytiahnutie bank ktore potrebujeme pri formulari pri zadavani platby
    	return view('payment', compact('banks'));
    }


    public function sendEmail(Request $request)
    {
    	$payment = $this->validatePayment();
    	$bank = DB::table('banks')->where('id', $payment['bank'])->get(); // najdeme si banku podla id ktore nam prislo z requestu z formulara
    	$account_number = $bank->implode('account_number'); // vytiahneme si cislo uctu tej banky
		$payment['account_number'] = $account_number; // a prilozime do arrayu , kde toto cislo uctu budeme potrebovat pri odosielani emailu
    	event(new SendEmail($payment)); // odpalime event posielanie emailu 

    	flash('Success ! Check your email and database')->success();
    	return redirect('/');
    }

    public function newBankForm() { // formular na pridanie novej banky
    	return view('create');
    }

    public function newBankCreate(Request $request) { // ulozenie banky do DB

    	$bank = $this->validateBank();
    	Bank::create([
    		'name' => $bank['bank_name'],
    		'account_number' => $bank['account_number']
    	]);

    	flash('New bank account successfully added')->success();
    	return redirect('/');
    }


    public function validateBank()
    {
    	return request()->validate([
            'bank_name' => 'required',
            'account_number' => 'required',
        ]
      ); 
    }

    public function validatePayment()
    {

    	return request()->validate([
            'from' => 'required',
            'bank' => 'required',
            'price' => 'required',
            'date' => 'required',
            'ks' => 'required',
            'vs' => 'required',
            'ss' => 'required',
            'note' => 'required'
        ],
        [
          'from.required' => 'You need to fill up your credit card number',
          'bank.required' => 'Choose one of payment method',
        ]
      ); 
    }
}


