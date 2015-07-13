<?
class Post extends AppModel{
	
	public $actsAs = array('Containable');

	public $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'post_id'
		),

		'Video' => array(
			'className' => 'Video',
			'foreignKey' => 'post_id'
		)
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'Tema' => array(
			'className' => 'Tema',
			'foreignKey' => 'tema_id'
		)
	);

	public $name = 'Post';

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		),
		'tema_id' => array(
			'rule' => 'notEmpty'
		),
		'body' => array(
			'rule' => 'notEmpty'
			)
	);

	public function isOwnedBy($post, $user) {
	    return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}


	/*
	function afterFind($results = array(), $primary = false) {

		foreach ($results as &$post) {
			if (empty($post['Image'])) {
				$post['Post']['noimage'] = true;
			}
		}

		return $results;
	}
	*/


	function getFechas() {
		$fechainit = $this->find('first', array(
			'fields' => array('Post.created'),
			'contain' => array(),
			'order' => array('Post.created' => 'ASC')
		));
		$fechafin = $this->find('first', array(
			'fields' => array('Post.created'),
			'contain' => array(),
			'order' => array('Post.created' => 'DESC')
		));	

		$fechainicial = new DateTime($fechainit['Post']['created']);
		$fechafinal = new DateTime($fechafin['Post']['created']);
		$meses = $fechainicial->diff($fechafinal);
		$meses = ($meses->y * 12) + $meses->m;
		$fechas = array();
		for ($i=0; $i <=$meses ; $i++)
		{	
			$fechas[$fechafinal->format('m-Y')] = $fechafinal->format('M Y');
			$fechafinal->modify('-1 month');
		}
		return $fechas;
	}


}