<?php

/**
 * Klasa zawierajaca pomocnicze metody
 * 
 * @author Andrzej Sawoniewicz <skorp@wp-sa.pl>
 * @package Ppias
 * @version $Revision: 1.2 $ 
 */
class Ppias_Helper
{
	/**
	 * Funckja konwertująca pola tablicy z ISO-8859-2 z UTF-8
	 *
	 * @param array $table
	 * @return array
	 */
	public static function arrayIso2Utf($table) {
		$converted = array();
		foreach ($table as $key => $value) {
			if (is_array($value)) {
				$converted[$key] = self::arrayIso2utf($value);
			} else {
				$converted[$key] = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-2');
			}
		}
		return $converted;
	}
	
	
	/**
	 * Zwraca losowy element na podstawie wag
	 *
	 * @param array $values
	 * @param array $weights
	 * @return mixed
	 */
	public static function weightedRandom($values, $weights) {
		$count = count($values); 
		$i = 0; 
		$n = 0; 
		$num = mt_rand(0, array_sum($weights)); 
		while ($i < $count) {
		    $n += $weights[$i]; 
		    if ($n >= $num) {
		        break; 
		    }
		    $i++; 
		} 
		return $values[$i]; 
	}

}
