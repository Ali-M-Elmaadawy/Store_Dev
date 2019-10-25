<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{
	private $apiContext;
	private $secret;
	private $clientId;

	public function __construct() {
        $paypalConfig = \Config::get('paypal');
		if($paypalConfig['settings']['mode'] == 'live') {

			$this->clientId = config('paypal.live_client_id');
			$this->secret = config('paypal.live_secret');

		} else {

			$this->clientId = $paypalConfig['sandbox_client_id'];

			$this->secret = $paypalConfig['sandbox_secret'];		
		}

		$this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId ,$this->secret));
		// $this->apiContext = setConfig($paypalConfig['settings']);
        // $this->apiContext = config($paypalConfig['settings']);
	}
    public function payWithPaypal(Request $request) {

    		$price = $request->price;
    		$name = $request->name;

			$payer = new Payer();
			$payer->setPaymentMethod("paypal");

			$item = new Item();
			$item->setName($name)
			    ->setCurrency('USD')
			    ->setQuantity(1)
			    ->setDescription("Products Description")
			    ->setPrice($price);


			$itemList = new ItemList();
			$itemList->setItems(array($item));

			//Amount

			$amount = new Amount();
			$amount->setCurrency("USD")
			    ->setTotal($price);

			//Transaction    
			$transaction = new Transaction();
			$transaction->setAmount($amount)
			    ->setItemList($itemList)
			    ->setDescription("Buying Some Thing");


			//Redirect URL

			$redirectUrls = new RedirectUrls();
			$redirectUrls->setReturnUrl('http://localhost:8000/payment_status')
			    ->setCancelUrl('http://localhost:8000/payment_cancelled');


			//Payment
			
			$payment = new Payment();
			$payment->setIntent("sale")
			    ->setPayer($payer)
			    ->setRedirectUrls($redirectUrls)
			    ->setTransactions(array($transaction));


			try {
			    $payment->create($this->apiContext);
			} catch (\PayPal\Exception\PPConnectionException $ex) {
				die($ex);

			} 

			$approvalUrl = $payment->getApprovalLink();

			return redirect($approvalUrl);


    }

    public function paymentsuccess(){}

    public function paymentcancelled(){

    	return 'Payment Cancelled';
    }


}
