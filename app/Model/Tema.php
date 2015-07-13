<?
class Tema extends AppModel{

	public $hasMany = array(
	'Post' => array(
		'className' => 'Post',
		'foreignKey' => 'tema_id'
		)
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty'
		)
	);
}