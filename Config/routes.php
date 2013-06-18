<?php
  Router::connect('/', array('controller' => 'dev'));
	Router::connect('/connection', array('controller' => 'dev', 'action'=>'connection'));
	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
