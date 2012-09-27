<?php 

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initRegistry()
	{
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);

		Zend_Registry::set('options', $this->getOptions());

		$this->bootstrap('db');
		Zend_Registry::set('db', $this->getResource('db'));

		$this->bootstrap('cachemanager');
		Zend_Registry::set('cachemanager', $this->getResource('cachemanager'));

		$this->bootstrap('log');
		Zend_Registry::set('log', $this->getResource('log'));

		$this->bootstrap('facebook');
		Zend_Registry::set('facebook', $this->getResource('facebook'));

		$this->bootstrap('session');
		$sessionData = $this->getResource('session');
    }


    protected function _initAutoload()
    {
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Ppias');

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }


    protected function _initFacebook()
    {
    	$options = $this->getOptions();

		header('P3P: CP="CAO PSA OUR"');
    	require_once($options['facebook']['api']['path']);
		$options = $this->getOptions();

		$facebook = new Facebook(array(
			'appId'  => $options['facebook']['app']['id'],
			'secret' => $options['facebook']['app']['secret'],
		));
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
		Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;

		return $facebook;
    }

    protected function _initSession()
    {
		$this->bootstrap('facebook');
    	$facebook = $this->getResource('facebook');
    	$options = $this->getOptions();

		$requestUri = parse_url($_SERVER['REQUEST_URI']);
		$scriptUrl = $requestUri['path'];
		$appPath = $options['facebook']['app']['url'] . (string) strstr($scriptUrl, 'index');

		$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'user_photos',
			'redirect_uri' => PROTOCOL . $appPath,
		));

		$user = $facebook->getUser();

		if (!$user) {
			echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
			exit;
		} else {
			try {
				$me = $facebook->api('/me');
			} catch (FacebookApiException $e) {
				echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
				exit;
			}
		}
		if (empty($me['id'])) {
			throw new Exception('Nie mozna pobrac id uzytkownika');
		}

		return array(
			'user' => $user,
			'me' => $me,
		);
    }
}
