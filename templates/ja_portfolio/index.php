<?php
if (class_exists('T3Template')) {
	$tmpl = T3Template::getInstance($this);
	$tmpl->render();
	return;
} else {
	//Need to install or enable JAT3 Plugin
	echo JText::_('Missing jat3 framework plugin');
}