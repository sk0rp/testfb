<?php

/**
 * Abstrakcyjna klasa modelu
 *
 * @author Andrzej Sawoniewicz <skorp@wp-sa.pl>
 * @package Default_Model
 * @version $Revision: 1.2 $ 
 */
abstract class Default_Model_Abstract
{
	/**
	 * Biblioteka operujaca na bazie danych
	 *
	 * @var Default_Model_DbLib
	 */
	protected $_dbLib;
	
	/**
	 * Przechowuje dane obiektu
	 * 
	 * @var array
	 */
	protected $_data;
	
	
	/**
	 * Publiczny konstruktor
	 * 
	 * @return void
	 */
	public function __construct(array $data = null)
	{
		if (is_array($data)) {
            $this->setData($data);
        }
        $this->_dbLib = Default_Model_DbLib::getInstance();
	}
	
	
	/**
	 * Ustawia dane dla obiektu
	 * 
	 * @param array $data
	 * @return Default_Model_Abstract
	 */
	public function setData(array $data)
	{
		$methods = get_class_methods($this);
		foreach ($data as $name => $value) {
			$method = 'set' . ucfirst($name);
			if (in_array($method, $methods)) {
                $this->$method($value);
            } else if(array_key_exists($name, $this->_data)) {
            	$this->_data[$name] = $value; 
            }
		}
		return $this;
	}
	
	
	/**
	 * Zwraca dane obiektu w postaci tablicy
	 * 
	 * @return array
	 */
	public function getData()
	{
		return $this->_data;
	}
	
	
	/**
	 * Magiczna metoda do ustawiania atrybutow obiektu
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (method_exists($this, $method)) {
			$this->$method($value);
		} else if (array_key_exists($name, $this->_data)) {
			$this->_data[$name] = $value; 
		}
		throw new Exception('Invalid property');
	}
	
	
	/**
	 * Magiczna metoda do pobierania atrybutow obiektu
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) 
	{
		$method = 'get' . $name;
		if (method_exists($this, $method)) {
            return $this->$method();
        } else if (array_key_exists($name, $this->_data)) {
			return $this->_data[$name];
		}
		throw new Exception('Invalid property: ' . $name);
	}
	
	
	/**
	 * Sprawdza dostepnosc atrybutu
	 * 
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name)
    {
    	return isset($this->_data[$name]);
    }
}
