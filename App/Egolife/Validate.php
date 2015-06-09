<?php
use \models\DB;
class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach ($items as $item => $rules) {
			foreach($rules as $rule => $rule_value){

				$value = $source[$item];
				if($rule === 'required' && empty($value)){
					isset($rule_value[1]) ? $this->addError($rule_value[1]) : $this->addError("{$item} is required");
		
				} else if(!empty($value)){
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} chars.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} chars.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()){
								$this->addError("{$item} already exists.");
							}
						break;
						case 'digitsOnly':
							if (!preg_match('/^[0-9]+$/', $value)) {
								$this->addError("{$item} must contain only digits 0-9.");
							}
						break;
						case 'exists':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if(!$check->count()){
								$this->addError("{$item} not found in a system!");
							}
						break;
					}
				}
			}
		}

		if(empty($this->_errors)){
			$this->_passed = true;
		}

		return $this;
	}

	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}