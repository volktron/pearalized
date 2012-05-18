<?php

/*
 * string.class.php
 * @author Henrik Volckmer
 *
 */
 
namespace pearalized\lib;

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
			$this->val = trim($this->val, $charlist);
		else
			$this->val = trim($this->val);
		return $this;
	}
	
	// Left trim
	public function ltrim($charlist = null)
	{
		if ($charlist)
			$this->val = ltrim($this->val, $charlist);
		else
			$this->val = ltrim($this->val);
		return $this;
	}

	// Right trim
	public function rtrim($charlist = null)
	{
		if ($charlist)
			$this->val = rtrim($this->val, $charlist);
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
		
	// String replace
	public function replace($pattern, $replacement, $regex = false, $limit = -1, &$count = null)
	{
		if (!$regex)
			$this->val = str_replace($pattern, $replacement, $this->val);
		else
			$this->val = preg_replace($pattern, $replacement, $this->val, $limit, $count);
		
		return $this;
	}
	
	// Combine str_split and preg_split
	public function split($var = 1, $delims = false, $offsets = false, $limit = -1)
	{
		
		if (is_int($var))
			return str_split($this->val, $var);
		else
		{
			$flags = 0;
		
			if($delims)
				$flags |= PREG_SPLIT_DELIM_CAPTURE;
			if($offsets)
				$flags |= PREG_SPLIT_OFFSET_CAPTURE;
			return preg_split($var, $this->val, $limit, $flags);
		}
	}
	
	// explode a string into array
	public function explode($separator, $limit=false)
	{
		if (is_int($limit))
			return explode($separator, $this->val, $limit);
		else
			return explode($separator, $this->val);
	}

}

?>
