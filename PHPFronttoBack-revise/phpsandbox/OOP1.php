<?php
	class Person {
		// public $name;
		// public $email;

		private $name;
		private $email;
		// public static $ageLimit = 40;
		private static $ageLimit = 40;

		public function __construct($name, $email){
			$this->name = $name;
			$this->email = $email;
			// echo 'Person created<br>';
			echo __CLASS__.' created<br>';
		}

		public function __destruct(){
			echo __CLASS__.' destroy<br>';
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getName(){
			return $this->name.'<br>';
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getEmail(){
			return $this->email.'<br>';
		}


		public static function getAgeLimit(){
			return self::$ageLimit;
		}
	}

	// $person1 = new Person;

	// $person1->setName('Jonh Doe');
	// echo $person1->getName();

	// $person1 ->name = 'Jonh Doe';
	// echo $person1->name;

	// $person1 = new Person('Jonh Doe', 'jdoe@gmail.com');
	// echo $person1->getName();
	// echo $person1->getEmail();


	class Customer extends Person{
		private $balance;

		public function __construct($name, $email, $balance){
			parent::__construct($name, $email, $balance);
			$this->balance = $balance;
			echo 'A new '.__CLASS__.' has been created<br>';
		}

		public function setBalance($balance){
			$this->balance = $balance;
		}

		public function getBalance(){
			return $this->balance.'<br>';
		}
	}

	// $customer1 = new Customer('Jonh Doe', 'jdoe@gmail.com', 300);
	// echo $customer1->getBalance();

	#Static props and method
	// echo Person::$ageLimit;
	echo Person::getAgeLimit();
?>