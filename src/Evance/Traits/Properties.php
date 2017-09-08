<?php

namespace Evance\Traits;

trait Properties{
	
	protected $properties = array();
	
	public function __get($name) {
		return $this->get($name);
	}
	
	public function __isset($name){
		return $this->hasProperty($name);
	}
	
	public function __set($name, $value) {
		$this->set($name, $value);
	}
	
	public function hasProperty($name){
		return isset($this->properties[$name]);
	}
	
	public function get($property, $default=null){
		if(!$this->hasProperty($property)){ return $default; }
		return $this->properties[$property];
	}
	
	public function set($property, $value){
		$this->properties[$property] = $value;
		return $this;
	}
	
	public function merge(/*..*/){
		$arguments = func_get_args();
		foreach($arguments as $argument){
			if(is_array($argument)){
				$this->properties = array_merge($this->properties, $argument);
			} elseif(is_object($argument)){
				$this->properties = array_merge($this->properties, get_object_vars($argument));
			} else {
				throw new InvalidArgumentException("Invalid property array");
			}
		}
		return $this;
	}
	
}