<?php 

return [

	//sandbox
		'sandbox_client_id'=>env('PAYPAL_SANDBOX_CLIENT_ID'),
		'sandbox_secret'   =>env('PAYPAL_SANDBOX_SECRET'),

	//live

		'live_client_id'=>env('PAYPAL_LIVE_CLIENT_ID'),
		'live_secret'   =>env('PAYPAL_LIVE_SECRET'),


		//Paypal_SDK configuration(eltkwen)

		'settings'=> [
						//Mode live or sandbox
						'mode'=>env('PAYPAL_MODE' , 'sandbox'),
						//Connection Timeout
						'http.ConnectionTimeOut'=>3000,
						//logs
						'log.LogEnabled'=>true,
						'log.FileName'=>storage_path().'/logs/paypal.log',
						'log.LogLevel'=>'DEBUG'



					]

		];