<?php 
return [ 
	'config' => [
    'oauth' => [
            'callback'         => env('CALLBACK','http://localhost/'),
            'consumer_key'     => env('CONSUMER_KEY','S45SJUFIOHTFPFCYEH5Z5PYODKPU9I'),
            'consumer_secret'  => env('CONSUMER_SECRET','MEBX99TOYH5G1ODZJU6PMMSYBOCYRJ'),
            'app_type' => env('APP_TYPE','PRIVATE'),
            'rsa_private_key'  => env('RSA_PRIVATE_KEY','file:///home/ubuntu/piceprivatekey.pem'),
        ],
    ]    
];