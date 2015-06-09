<?php
class Hash {
	public static function make($string, $salt = '') {
		return hash('sha256', $string . $salt);
	}
	public static function salt($length) {

		$unique_random_string = md5(uniqid(mt_rand(), true));

		$base64_string = base64_encode($unique_random_string);

		$modified_base64_string = str_replace('+', '.', $base64_string);

		$salt = substr($modified_base64_string, 0 , $length);

		return $salt;
	}

	public static function unique() {
		return self::make(uniqid());
	}
}