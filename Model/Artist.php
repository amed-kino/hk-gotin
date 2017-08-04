<?php
App::uses('AppModel', 'Model');
/**
 * Artist Model
 *
 */
class Artist extends AppModel {
    
    
    public $unique=true;
    public $letter;
    
    public $actsAs = array(
                
        );
            
            
    public $hasMany = array(
        'Album' => array(
        'className' => 'Album',
        'conditions' => array('Album.available' => 'yes','Album.deleted' => 'no'),
        'order'=>array('Album.year DESC')
        )
    );
    public $belongsTo = array(
                    'User' => array(
                            'className' => 'User',
                            'conditions' => '',
                            'counterCache' => 'artist_counter', 
                            'counterScope' => array( 'Artist.available' => 'yes'),                        
                            'fields' => array('username','unique','name'),
                            'order' => ''
                    ),  
        );

    
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
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
		'name' => array(
			'isKurdish' => array(
				'rule' => array('isKurdish'),
				'message' => 'Only Kurdish-Latin alphabet is allowed.',
			),                    
			'artistExist' => array(
				'rule' => array('artistExist'),
				'message' => 'Artist name is already exists.',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave artist name blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',32),
				'message' => 'At maximum 32 letters',
			),
			'minLength' => array(
				'rule' => array('minLength',2),
				'message' => 'At least 2 letters.',
			),
		),
                
            );
     

        
 

     
     
    public function isOwnedBy($artist_id = null,$user_id = null) {
       return $this->field('id', array('Artist.id' => $artist_id, 'Artist.user_id' => $user_id)) !== false;
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





     function beforeSave($options = array()) {
         parent::beforeSave($options);
         
         if (isset($this->data['Artist']['name'])){$this->data['Artist']['name'] = $this->sanitize($this->data['Artist']['name'], "-'");}
         if ($this->unique==true){
            $unique=$this->getUnique();
            $this->data['Artist']['unique']=$unique;
            $this->unique=$unique;
         }
        
        if (isset($this->data['Artist']['name'])){$this->letter($this->data['Artist']['name']);}
        
       
     }

    public function letter($artist){
         $letter=mb_substr($artist,0,1,'utf-8');
         $this->letter=$letter;
         return $letter;
     }  
     function beforeDelete($cascade = true) {
         
         parent::beforeDelete($cascade);
         $data=$this->findById($this->id);         
         $this->letter($data['Artist']['name']);
         
         
         
         $this->bindModel(array('hasOne'=>array('trashArtist')));
         $data=$data['Artist'];
         $data['id_old']=$data['id'];
         unset($data['id']);    
         $this->trashArtist->create();
         if ($this->trashArtist->save($data)){return TRUE;}  else {return TRUE;}
         
     }


     /**
 * Find unique of an id.
 *
 * @var string
 */

    public function findUnique($id){$unique=$this->findById($id,array('fields'=>'unique'));
        return $unique['Artist']['unique'];
    }

    

private function _getid(){$len = 8;
            $base_='12340';
            $base='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890012345678901234567890123456789AaZz99';
            $max=strlen($base)-1;
            $str_uid='';
            
            mt_srand((double)microtime()*999999999);
            
            while (strlen($str_uid)<$len+1)
            $str_uid.=$base{mt_rand(0,$max)};
            return $str_uid;

}

public function getUnique(){do {$uid=$this->_getid();    
                if(!$this->findByUnique($uid)){return $uid;
                    break;
                }
        }
        while (9==9);

    

}

public function del(){
        
        if ($this->id == null){return false;}
        if ($this->saveField('deleted', 'yes')){
            
            
            
            
            $dataArray1['Album.deleted'] = '\'yes\'';
            $conditions1['Album.artist_id'] = $this->id;
            $this->Album->updateAll($dataArray1,$conditions1);
            
            $dataArray2['Lyric.deleted'] = '\'yes\'';
            $conditions2['Lyric.artist_id'] = $this->id;
            
            $this->Lyric = ClassRegistry::init('Lyric');
            
            $this->Lyric->updateAll($dataArray2,$conditions2);
            
            return true;
            
        }else{return false;}
        
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
public function artistExist($_check){
    return ($this->find('count', array('conditions' => array('LOWER(Artist.name)' => strtolower($this->data['Artist']['name']) ))) == 0);
    }
    
  

}
