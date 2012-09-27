<?php

class Zend_View_Helper_Str extends Zend_View_Helper_Abstract
{
	public function str($pages, $page, $urlPrefix)
	{
		if ($pages < 2) {
			return '';
		}
		$options = Zend_Registry::get('options');
		$string = '<div id="str">';
		for ($i = 1; $i <= $pages; $i++) {
			if ($page == $i) {
				$string .= '<span>' . $i . '</span>';
			} else if ($i == 1) {
				$string .= '<a href="' . $urlPrefix . '" target="_top">' . $i . '</a>';
			} else {
				$string .= '<a href="' . $urlPrefix . 'page/' . $i . '" target="_top">' . $i . '</a>';
			}
		}
		$string .= '</div>';
		return $string;
	}
}
