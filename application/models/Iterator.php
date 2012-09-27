<?php

/**
 * Kolekcja
 *
 * @author Andrzej Sawoniewicz <skorp@wp-sa.pl>
 * @package Default_Model
 * @version $Revision: 1.2 $ 
 */
abstract class Default_Model_Iterator implements Iterator
{
	/**
	 * Tablica elementow
	 * 
	 * @var array
	 */
	protected $_elements;
	
	
	/**
	 * Publiczny konstruktor
	 * 
	 * @param array $elements
	 * @return void
	 */
	public function __construct(array $elements = null)
	{
		$this->_elements = $elements;
	}
	
	
	/**
	 * Zwraca tablice elementow
	 * 
	 * @return array
	 */
	public function asArray()
	{
		$this->rewind();
		return $this->_elements;
	}


	/** 
	 * Przewija iterator do poczatku
	 *  
	 * @return void 
	 */ 
	public function rewind()
	{
		reset($this->_elements);
	}
    

	/** 
	 * Zwraca aktualny element
	 * 
	 * @return Object
	 */ 
	public function current()
	{
		return current($this->_elements);
	} 


	/**
	 * Zwraca klucz aktualnego elementu
	 *  
	 * @return mixed
	 */ 
	public function key()
	{
		return key($this->_elements);
	} 
	
	
	/** 
	 * Przesuwa wskaznik do nastepnego elementu
	 * 
	 * @return void 
	 */ 
	public function next()
	{
		next($this->_elements);
	}
	
	
	/** 
	 * Sprawdza prawidlowosc aktualnego elementu po metodach rewind() lub next(). 
	 * 
	 * @return boolean 
	 */ 
	public function valid()
	{
		$current = $this->current();
		return $current === false ? false : true;
	}
	
	
	/**
	 * Zwraca ilosc elementow
	 * 
	 * @return int
	 */
	public function count()
	{
		return count($this->_elements);
	}
	
	
	/**
	 * Zwraca tablice kluczy
	 * 
	 * @return array
	 */
    public function getKeys()
    {
    	return array_keys($this->_elements);
    }
    
    
    /**
	 * Sprawdza czy element o danym kluczu istnieje
	 * 
	 * @param mixed $key
	 * @return bool
	 */
    public function hasKey($key)
    {
    	return isset($this->_elements[$key]);
    }
    
    
    /**
	 * Sprawdza czy tablica elementow jest pusta
	 * 
	 * @return bool
	 */
    public function isEmpty()
    {
    	return empty($this->_elements);
    }
}
