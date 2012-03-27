<?php

/*
 * string.class.php
 * @author Henrik Volckmer
 *
 */
 
namespace pearless\lib;

class PString
{
	public $val;

	public function __construct($string)
	{
		$this->val = $string;
	}
	
	// So you can concat PStrings to regular php strings
	public function __toString()
	{
		return $this->val;
	}
	
	// Trim
	public function trim($charlist = null)
	{
		if ($charlist)
			$this->val = trim($this->val, $charlist)
		else
			$this->val = trim($this->val);
		return $this;
	}
	
	// Left trim
	public function ltrim($charlist = null)
	{
		if ($charlist)
			$this->val = ltrim($this->val, $charlist)
		else
			$this->val = ltrim($this->val);
		return $this;
	}

	// Right trim
	public function rtrim($charlist = null)
	{
		if ($charlist)
			$this->val = rtrim($this->val, $charlist)
		else
			$this->val = rtrim($this->val);
		return $this;
	}
	
	// Combine strstr and substr into one method.
	public function sub($needle, $length = 0)
	{
		if (is_int($needle))
			if ($length == 0)
				$this->val = substr($this->val, $needle);
			else
				$this->val = substr($this->val, $needle, $length);
		else
			$this->val = strstr($this->val, $needle);
		return $this;
	}
	
	// Convert to lowercase
	public function lower()
	{
		$this->val = strtolower($this->val);
		return $this;
	}
	
	// Convert to uppercase
	public function upper()
	{
		$this->val = strtoupper($this->val);
		return $this;
	}
	
	// Combine str_split and preg_split
	public function split($var = 1, $limit = -1, $flags = 0)
	{
		if (is_int($var)
			return str_split($this->val, $var);
		else
			return preg_split($var, $this->val, $limit, $flags);
	}
}

?>
