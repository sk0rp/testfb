<?php
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract {

	public function menu($user) {
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$actionName = $request->getActionName();
    	$options = Zend_Registry::get('options');
		$appPath = $options['facebook']['app']['url'];

		$menu = array(
			'Main Page' => array(
				'title' => 'Main Page', 
				'url' => $appPath,
			),
			'Next Page' =>  array(
				'title' => 'Next Page', 
				'url' => $appPath . 'index/next',
			),
		);


		$tabmap = array(
			'index' => 'Main Page',
			'next' => 'Next Page',
		);
	
		if (isset($tabmap[$actionName])) {
			$menu[$tabmap[$actionName]]['active'] = true;
		}
		
		return $menu;
	}
 
}


