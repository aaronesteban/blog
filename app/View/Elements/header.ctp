<?if(!empty($this->Session->read('Auth.User'))):?>
	<a href="<?= Router::url(array('controller' => 'users', 'action' => 'logout')); ?>">Logout</a>
	<a href="<?= Router::url(array('controller' => 'users', 'action' => 'add')); ?>">Registrar usuarios</a>
<?else:?>
	<a href="<?= Router::url(array('controller' => 'users', 'action' => 'login')); ?>">Login</a>
<?endif;?>
