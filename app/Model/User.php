<?
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
    
    public $hasMany = array(
    	'Post' => array(
    		'className' => 'Post',
			'foreignKey' => 'user_id'
		)
    );

	public $validate = array(
		'name' => array(
			'nonEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A name is required',
				'allowEmpty' => false
			),
			'between' => array(
				'rule' => array('between', 4, 15),
				'required' => true,
				'message' => 'Usernames must be between 4 to 15 characters'
			),
		),
		'username' => array(
			'nonEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required',
				'allowEmpty' => false
			),
			'between' => array(
				'rule' => array('between', 4, 15),
				'required' => true,
				'message' => 'Usernames must be between 4 to 15 characters'
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This username is already in use'
			),
			'alphanumericDashUnderscore' => array(
				'rule' => array('alphanumericDashUnderscore'),
				'message' => 'Username can only be letters, numbers and underscores',
			),
		),
		'password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			),
			'min_length' => array(
				'rule' => array('minLength', '6'),
				'message' => 'Password must have a minimum of 6 characters'
			)
		),
		'password_confirm' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please confirm your password'
			),
			'equaltofield' => array(
				'rule' => array('equaltofield','password'),
				'message' => 'Both passwords must match.'
			)
		),
		'email' => array(
			'required' => array(
				'rule' => array('email', true),
				'message' => 'Please provide a valid email adress.'
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'This email is already in use',
			),
			'between' => array(
				'rule' => array('between', 6, 60),
				'message' => 'Usernames must be between 6 to 60 characters'
			)
		)
	);
	
	public function alphaNumericDashUnderscore($check){
		$value = array_values($check);
		$value = $value[0];

		return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
	}

	public function equaltofield($check,$otherfield){ 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 

    public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new BlowfishPasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }
    	return true;
    }

}