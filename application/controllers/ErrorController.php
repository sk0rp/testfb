<?php

class ErrorController extends Zend_Controller_Action
{
	public function init()
	{
		$this->options = Zend_Registry::get('options');

		$this->view->appId = $this->options['facebook']['app']['id'];
		$this->view->appUrl = $this->options['facebook']['app']['url'];
		$this->view->wpUrl = $this->options['facebook']['app']['callback'];
	}


	public function errorAction()
	{
		$errors = $this->_getParam('error_handler');
		$log = Zend_Registry::get('log');

		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->message = 'Sorry, the page you requested was not found.';
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->_helper->layout->setLayout('error');
				$this->view->message = 'Sorry, an error has occurred.';
				$log->log($errors->exception->getMessage(), Zend_Log::ERR);
				break;
		}

		$this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;
	}
	
}
