<?
class PostsController extends AppController{
	public $helpers = array('Html','Form');

	public function isAuthorized($user) {
    // All registered users can add posts
	    if ($this->action === 'add') {
	        return true;
	    }

	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('edit', 'delete'))) {
	        $postId = (int) $this->request->params['pass'][0];
	        if ($this->Post->isOwnedBy($postId, $user['id'])) {
	            return true;
	        }
	    }

	    return parent::isAuthorized($user);
	}

	function index(){
		$params = array('limit' => 5, 'first' => 'First page');
		if (isset($this->request->params['named']['tema'])) {
			$params['conditions'] = array('tema_id' => $this->request->params['named']['tema']);
		}
		if (isset($this->request->params['named']['fecha'])) {
			$params['conditions'] = array("date_format(created, '%m-%Y')" => $this->request->params['named']['fecha']);
		}
		$this->paginate = $params;
		$posts = $this->paginate();
		$this->set('posts', $posts);

		$temas = $this->Post->Tema->find('list');
		$this->set('temas', $temas);

		$fechas = $this->Post->getFechas();
		$this->set('fechas', $fechas);
	}


	function view($id = null){
		$this->Post->id = $id;
		$post = $this->Post->read();
		$this->set('post', $post);

		/*
		$post = $this->Post->find('first', array(
			'conditions' => array('Post.id' => $id)
		));
		debug($post);
		*/
	}

	function _renameImage($filename=null){
		if(!$filename){
			throw new Exception("Error Processing Request", 1);
		}
		$count = $this->Post->Image->find('count', array('conditions' => array('Image.name' => $filename)));
		$new_filename = $filename;

		if ($count > 0) {
			$cont = 1;
			while ($count !== 0)
			{
				$new_filename = explode('.', $filename);
				$new_filename = $new_filename[0].$cont.'.'.$new_filename[1];
				$count = $this->Post->Image->find('count', array('conditions' => array('Image.name' => $new_filename)));
				$cont++;
			}
		}

		return $new_filename;

	}

	function _add_video($video=null){
		if(!$video){
			throw new Exception("Error Processing Request", 1);
		}
		$buscar = 'vimeo';
		//youtube
		if (strpos($video, $buscar) === false) {
			$video = explode('=', $video);
			$video = $video[1];
			$clase = 'youtube';
		}
		//vimeo
		else{
			$video = explode('/', $video);
			$video = $video[3];
			$clase = 'vimeo';
		}

		return array($video, $clase);
	}

	function add(){
		if ($this->request->is('post')) {
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			if ($this->Post->save($this->request->data)) {
				$post_id = $this->Post->id;

				$video = $this->request->data['Video']['name'];
				if(!empty($video)){
					list($nombre_video, $clase_video) = $this->_add_video($video);
					$video_save = array('name' => $nombre_video, 'post_id' => $post_id, 'clase' => $clase_video);
					$this->Post->Video->create();
					$this->Post->Video->save($video_save);
				}

				if(!empty($this->data['File'])){
					foreach ($this->data['File'] as $img) {
						$nombrearchivo = $this->_renameImage($img['file']['name']);
						/* copiamos el archivo*/
						if (move_uploaded_file($img['file']['tmp_name'], WWW_ROOT . "files/" . $nombrearchivo)) {
						/* mensaje al usaurio */
							$image_save = array('name' => $nombrearchivo, 'post_id' => $post_id);
							$this->Post->Image->create();
							$this->Post->Image->save($image_save);
							$this->Session->setFlash('Archivo subido satisfactoriamente');
						} else {
						/* mensaje al usaurio */
							$this->Session->setFlash('Error al subir el archivo, verificar.');
						}

					}
				}

				$this->Session->setFlash('Your post has been saved.');
			}

			$this->redirect(array('action' => 'index'));
		}
		$temas = $this->Post->Tema->find('list');
		$this->set('temas', $temas);
		//$this->set(compact('temas'));
	}

	function edit($id = null){
		if(!$id){
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if(!$post){
			throw new NotFoundException(__('Invalid post'));
		}

		if($this->request->is(array('post','put'))){
			$this->Post->id = $id;
			if($this->Post->save($this->request->data)){
				$this->Session->setFlash(__('Your post has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your post.'));
		}

		if(!$this->request->data){
			$this->request->data = $post;
		}
	}

	function delete($id = null){
		if(!$this->request->is('post')){
			throw new MethodNotAllowedException();
		}
		if($this->Post->delete($id)){
			$this->Session->setFlash('The post with id: ' .$id. ' has been deleted.');
			$this->redirect(array('action' => 'index'));
		}
	}

}