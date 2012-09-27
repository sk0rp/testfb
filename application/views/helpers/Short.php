<?php

class Zend_View_Helper_Short extends Zend_View_Helper_Abstract
{
	public function short($string, $length, $end = '...')
	{
		if (strlen($string) <= $length) {
			return $string;
		}
		return mb_substr($string, 0, $length, 'UTF-8') . $end;
	}
}
