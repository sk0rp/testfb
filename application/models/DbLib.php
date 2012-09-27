<?php

/**
 * Klasa operujaca na bazie danych
 *
 * @author Andrzej Sawoniewicz <skorp@wp-sa.pl>
 * @package Default_Model
 * @version $Revision: 1.5 $ 
 */
class Default_Model_DbLib
{
	/**
	 * Instancja singletona
	 * 
	 * @var Default_Model_DbLib
	 */
	private static $_instance;
	
	/**
	 * Adapter bazy danych
	 *
	 * @var Zend_Db_Adapter_Abstract
	 */
	protected $_db;
	
	/**
	 * Prywatny konstruktor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		$this->_db = Zend_Registry::get('db');
		$this->_log = Zend_Registry::get('log');
	}
	
	
	/**
	 * Zwraca instancje Default_Model_DbLib
	 *
	 * @return Default_Model_DbLib
	 */
	public static function getInstance()
	{
		return empty(self::$_instance) ? self::$_instance = new Default_Model_DbLib() : self::$_instance;
	}

	
	/**
	 * Testowe zapytanie
	 * 
	 * @param string $id
	 * @return array|bool
	 */
	protected function _cachedTest($id)
	{
		$query = 'SELECT *
		          FROM testfb WHERE id=:id';
		$binds = array(
			':id' => $id,
		);
		$row = $this->_db->fetchRow($query, $binds);
		if (empty($row)) {
			return false;
		}
		$result = $row;
		
		return $row;
	}
	
	/**
	 * Zwraca klucz cache dla metody _cachedGetUserData
	 * 
	 * @param string $uid
	 * @return string
	 */
	protected function _keyTest($id)
	{
		return 'getTest_' . $id;
	}
	
	
	/**
	 * Keszuje metody z przedrostkiem _cached
	 * 
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	public function __call($method, $args)
	{
		$cachedMethodName = '_cached' . $method;
		if (method_exists($this, $cachedMethodName)) {
			// pobieramy obiekt cache
			$cacheManager = Zend_Registry::get('cachemanager');
			$dbCache = $cacheManager->getCache('db');
	
			// generujemy klucz cache
			$keyMethodName = '_key' . $method;
			if (method_exists($this, $keyMethodName)) {
				$key = call_user_func_array(array($this, $keyMethodName), $args);
			} else {
				$key = $method . '_' . md5(serialize($args));
			}
			// sprawdzamy cache
			if ($dbCache->test($key)) {
				return $dbCache->load($key);
			}
			
			// cache pusty, uruchamiamy metode
			$result = call_user_func_array(array($this, $cachedMethodName), $args);
			
			// zapisujemy cache
			$dbCache->save($result, $key);

			return $result;
		}
        throw new Exception('Invalid method "' . $method . '"');
	}
	
	
	/**
	 * Usuwa cache o kluczu $key
	 * 
	 * @param string $key
	 */
	public function removeCache($key)
	{
		$cacheManager = Zend_Registry::get('cachemanager');
    	$dbCache = $cacheManager->getCache('db');
    	$dbCache->remove($key);
	}
}

