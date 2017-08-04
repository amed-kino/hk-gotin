<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {
    
    public $unique=true;
    public $recursive=1;
    public $belongsTo = array('Group' => array('fields'=>array('id','name')),);
    
   
    public $validate = array(
		'unique' => array(
                        'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'notUnique[9]',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Unique ID Issue! [NAlph#]',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Unique ID Issue!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(                    

			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Username is already in use.',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave username blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',24),
				'message' => 'At maximum 24 letters.',
			),
			'minLength' => array(
				'rule' => array('minLength',4),
				'message' => 'At least 4 letters.',
			),
			'HKUsername' => array(
				'rule' => array('HKUsername'),
				'message' => 'Username starts with letter and undercore (_) only allowed.',
			),                    
		),
		'email' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Email adress is already in use.',
                                
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave Email blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',64),
				'message' => 'maximum letters been reached',
			),
			'minLength' => array(
				'rule' => array('minLength',4),
				'message' => 'At least 4 letters.',
			),
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave Password blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',24),
				'message' => 'At maximum 24 letters.',
			),
			'minLength' => array(
				'rule' => array('minLength',6),
				'message' => 'At least 6 letters.',
			),
		),
		'name' => array(
			'maxLength' => array(
				'rule' => array('maxLength',24),
				'message' => 'At maximum 24 letters.',
			),
			'minLength' => array(
				'rule' => array('minLength',4),
				'message' => 'At least 4 letters.',
			),
			'isKurdish' => array(
				'rule' => array('isKurdish'),
				'message' => 'Only Kurdish-Latin alphabet is allowed.',
			),                     
		),
            
);
            
        
        
        
    
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
     
        if ($this->unique===true){
           $unique=$this->getUnique();
           $this->data['User']['unique']=$unique;
           $this->unique=$unique;   
        }
    
     if (isset($this->data[$this->alias]['password'])) {
         $passwordHasher = new BlowfishPasswordHasher();
        $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
    }
    if (isset($this->data[$this->alias]['name'])){$this->data[$this->alias]['name'] = $this->sanitize($this->data[$this->alias]['name'], "-'");}
    if (isset($this->data[$this->alias]['username'])){$this->data[$this->alias]['username'] = strtolower($this->data[$this->alias]['username']);}
    if (isset($this->data[$this->alias]['first_name'])){$this->data[$this->alias]['first_name'] = $this->sanitize($this->data[$this->alias]['first_name'], "-'");}
    if (isset($this->data[$this->alias]['last_name'])){$this->data[$this->alias]['last_name'] = $this->sanitize($this->data[$this->alias]['last_name'], "-'");}
    
    return true;
}

    
    
    private function _getid(){$len = 8;
            $base='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890012345678901234567890123456789AaZz99';
            $max=strlen($base)-1;
            $str_uid='';
            
            mt_srand((double)microtime()*999999999);
            
            while (strlen($str_uid)<$len+1)
            $str_uid.=$base{mt_rand(0,$max)};
            return $str_uid;

    }

    public function getUnique(){
        
        do {
                $uid=$this->_getid();    
                    if(!$this->findByUnique($uid)){return $uid;
                        break;
                    }
            }
            
        while (9==9);
    }
    
    function HKUsername($check) {
        return (bool)(preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$check['username'])); 
    }
    
   
    
    
    
    public function createFromSocialProfile($incomingProfile){
 
    // check to ensure that we are not using an email that already exists
    $existingUser = $this->find('first', array(
        'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'])));
    
    if($existingUser){
        // this email address is already associated to a member
        return $existingUser;
    }
     
    $unique = $this->getUnique();
    
    if (filter_var($incomingProfile['SocialProfile']['email'], FILTER_VALIDATE_EMAIL)){
        $email = $incomingProfile['SocialProfile']['email'];
    }else{
        $email = 'emptyemail@hunerakurdi.com';
    }
    // brand new user
    $socialUser['unique'] = $unique;
    $socialUser['username'] = $unique;
    $socialUser['email'] = $email;
    $socialUser['password'] = '(A__DuZ_N)*99'.$unique;
    
    $socialUser['name'] = $incomingProfile['SocialProfile']['display_name'];
    $socialUser['first_name'] = $incomingProfile['SocialProfile']['first_name'];
    $socialUser['last_name'] = $incomingProfile['SocialProfile']['last_name'];
    $socialUser['available'] = 'yes';
//    $socialUser['User']['time_zone']
//    $socialUser['User']['birthday']
    
    $socialUser['social_network'] = 'yes';
    $socialUser['social_network_name'] = $incomingProfile['SocialProfile']['social_network_name'];
    $socialUser['social_network_id'] = $incomingProfile['SocialProfile']['social_network_id'];
    $socialUser['social_network_link'] = $incomingProfile['SocialProfile']['link'];
    $socialUser['social_network_picture'] = $incomingProfile['SocialProfile']['picture'];
    
//    $socialUser['User']['infos']
//    $socialUser['User']['created']
    $socialUser['group_id'] = 5;


     
    // save and store our ID
    if ($this->save($socialUser,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}
    $socialUser_c['User'] = $socialUser; 
    $socialUser_c['Group']['id'] = 5;
    return $socialUser_c;
     
 
    }

    
 function sanitize ($string, $delimiters = '', $encoding = 'UTF-8'){
    
    $string = preg_replace('/\s+/', ' ',$string);
    if ($encoding === NULL) { $encoding = mb_internal_encoding();}
    $exceptions=Configure::read('HK.uncapitalizedWords');
    if (is_string($delimiters))
    {
        $delimiters =  str_split( str_replace(' ', '', $delimiters));
    }

    $delimiters_pattern1 = array();
    $delimiters_replace1 = array();
    $delimiters_pattern2 = array();
    $delimiters_replace2 = array();
    foreach ($delimiters as $delimiter)
    {
        $uniqid = uniqid();
        $delimiters_pattern1[]   = '/'. preg_quote($delimiter) .'/';
        $delimiters_replace1[]   = $delimiter.$uniqid.' ';
        $delimiters_pattern2[]   = '/'. preg_quote($delimiter.$uniqid.' ') .'/';
        $delimiters_replace2[]   = $delimiter;
    }

    
    $return_string = trim($string);
    $return_string = preg_replace($delimiters_pattern1, $delimiters_replace1, $return_string);
    
    $words = explode(' ', $return_string);
    foreach ($words as $index => $word)
    {   
        $word=  mb_strtolower($word,$encoding);
        if (!$index==0){
            if (in_array(mb_strtolower($word,$encoding), $exceptions)) {
            $words[$index] = $word;
            }else{    
                $words[$index] = mb_strtoupper(mb_substr($word, 0, 1, $encoding), $encoding).mb_substr($word, 1, mb_strlen($word, $encoding), $encoding);
            }
        }else{
               $words[$index] = mb_strtoupper(mb_substr($word, 0, 1, $encoding), $encoding).mb_substr($word, 1, mb_strlen($word, $encoding), $encoding);
        }
    }
    $return_string = implode(' ', $words);
    $return_string = preg_replace($delimiters_pattern2, $delimiters_replace2, $return_string);
    return $return_string;
}    
public function isKurdish($_check){
    
    $_alphabit=Configure::read('HK.KurdishAlphabetExtended');
    $_nubmers=array('0','1','2','3','4','5','6','7','8','9',' ');
    $alphabit=  array_merge($_alphabit,$_nubmers);
    foreach ($_check as $check)
    $return_string = preg_replace('/\s+/', ' ',$check);
    
    $stringArray=preg_split('/(?<!^)(?!$)/u', $return_string);
    
    
    $condition=true;
    foreach ($stringArray as $index=> $letter) {    
        if (!in_array($letter, $alphabit)){
            $condition=false;
            break;
        }
    }
    if ($condition==TRUE){return TRUE;}else{return FALSE;}

 } 
 
}
