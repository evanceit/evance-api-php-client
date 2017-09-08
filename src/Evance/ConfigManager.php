<?php

namespace Evance;

class ConfigManager{
	use \Evance\Traits\Properties;
	
	public function __construct($config=array()) {
		$this->merge($config);
	}
	
}