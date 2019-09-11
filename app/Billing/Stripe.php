<?php 

namespace App\Billing;

class Stripe {

	Protected $key; 

	public function __construct($key){
		$this->key = $key;
	}

}