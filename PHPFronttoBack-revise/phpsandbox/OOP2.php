<?php

/*-----------------Public-----------------------------------------
class Customer{
	public $id = 1;
	public $name;
	public $email;
	public $balance;

	public function __construct($id, $name, $email, $balance){
		// echo 'The Constructor Ran...';
		$this->id = $id;
		$this->name =$name;
		$this->email = $email;
		$this->balance = $balance;
	}

	// public function getCustomer($id){
	// 	$this->id = $id;
	// 	// return 'John Doe';
	// 	return $this->id;
	// }

	// public function __destruct(){
	// 	echo 'The Destuctor Run...';
	// }

		public function getEmail(){
			return $this->email;		
		}
}

// $customer = new Customer;

// echo $customer->getCustomer(1); //John Doe

// echo $customer->getCustomer(10);



$customer = new Customer(1, 'Brad Traversy', 'brad@gmail.com', 0);

echo $customer->name;
*/

//---------------------Private--------------------------------------
/*
class Customer{
	private $id = 1;
	private $name;
	private $email;
	private $balance;

	public function __construct($id, $name, $email, $balance){
		// echo 'The Constructor Ran...';
		$this->id = $id;
		$this->name =$name;
		$this->email = $email;
		$this->balance = $balance;
	}

		public function getEmail(){
			return $this->email;		
		}
}


$customer = new Customer(1, 'Brad Traversy', 'brad@gmail.com', 0);

//กรณีประกาศ private จะเข้าถึงได้โดยผ่านฟังก์ชัน(getEmail) เท่านั้น
// echo $customer->getEmail();  //brad@gmail.com
echo $customer->email();  //Fatal error
//ถ้าฟังก์ชัน getEmail เป็น protected ก็จะเกิด Fatal error เช่นกัน
*/

//--------------------------class extends---------------------------------------------

/*
class Customer{
	private $id = 1;
	private $name;
	protected $email;
	private $balance;

	public function __construct($id, $name, $email, $balance){
		// echo 'The Constructor Ran...';
		$this->id = $id;
		$this->name =$name;
		$this->email = $email;
		$this->balance = $balance;
	}
}

class Subscriber extends Customer{
	public $plan;

	public function __construct($id, $name, $email, $balance, $plan){
		parent:: __construct($id, $name, $email, $balance);
		$this->plan = $plan;
	}

	public function getEmail(){
			return $this->email;		
	}
}

$subscriber = new Subscriber(1, 'Brad Traversy', 'brad@gmail.com', 0, 'Pro');

echo $subscriber->getEmail();

*/

/*
//Abstact Class

abstract class Customer{
	private $id = 1;
	private $name;
	protected $email;
	private $balance;

	public function __construct($id, $name, $email, $balance){
		// echo 'The Constructor Ran...';
		$this->id = $id;
		$this->name =$name;
		$this->email = $email;
		$this->balance = $balance;
	}

	abstract public function getEmail();
}

// $customer = new Customer(1, 'Brad Traversy', 'brad@gmail.com', 0);

class Subscriber extends Customer{
	public $plan;

	public function __construct($id, $name, $email, $balance, $plan){
		parent:: __construct($id, $name, $email, $balance);
		$this->plan = $plan;
	}

	public function getEmail(){
			return $this->email;		
	}
}

$subscriber = new Subscriber(1, 'Brad Traversy', 'brad@gmail.com', 0, 'Pro');

echo $subscriber->getEmail();
*/

class User{
	public $username;
	public $password;
	// public static $passwordLength = 5;
	private static $passwordLength = 5;

	public static function getPasswordLength(){
		return self:: $passwordLength;
	}
}

// echo User::getPasswordLength(); //5
echo User::$passwordLength; //5
//ถ้า $passwordLength เป็น private static จะ error
?>