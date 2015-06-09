<?php
namespace models;

class Config{
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['config'];
			$path = explode("/", $path);

			foreach ($path as $elem) {
				if(isset($config[$elem])){
					$config = $config[$elem];
				}
			}

			return $config;
		}

		return false;
	}
}