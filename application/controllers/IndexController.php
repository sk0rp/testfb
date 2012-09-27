<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_redirector = $this->_helper->getHelper('Redirector');
    	$this->_redirector->setUseAbsoluteUri(true);
    	$this->view->request = $this->_request;

    	$this->options = Zend_Registry::get('options');
    	$facebook = Zend_Registry::get('facebook');

    	$this->view->appId = $this->options['facebook']['app']['id'];
    	$this->view->appUrl = $this->options['facebook']['app']['url'];
    	$this->view->wpUrl = $this->options['facebook']['app']['callback'];
    	$this->view->ajax = $this->options['facebook']['app']['ajax'];
    	$this->view->accessToken = $facebook->getAccessToken();

    }


    /**
     * Prezentacja miejsca
     *
     * @return null
     */
	public function indexAction()
    {
		
    }

}

