<?php
App::uses('AppModel', 'Model');
/**
 * Album Model
 *
 * @property Artist $Artist
 */
class Album extends AppModel {
    
    public $unique=true;
    public $artistUnique;
    public $artistId;
    public $displayField = 'title';
    public $recursive=0;

    
        public $hasMany = array(
                'Lyric' => array(
                        'className'=>'Lyric',
                        'conditions' => array( 'Lyric.available' => 'yes','Lyric.deleted' => 'no'),
                        'order'=>array('Lyric.echelon')
                    
                    )
            );
        public $belongsTo = array(

                'Artist'=>array(
                        'className'=>'Artist',
                        'foreignKey' => 'artist_id',
                        'counterCache' => 'album_counter', 
                        'counterScope' => array( 'Album.available' => 'yes','Album.deleted' => 'no') 
                    ),
                'User' => array(
                            'className' => 'User',
                            'conditions' => '',
                            'counterCache' => 'album_counter', 
                            'counterScope' => array( 'Album.available' => 'yes'),                        
                            'fields' => array('username','unique','name'),
                            'order' => ''
                    ),  
            );
        
        
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
		'title' => array(
                    
			'dublicated' => array(
				'rule' => array('dublicated'),
				'message' => 'Album title is already exists.',
			),
			'isKurdish' => array(
				'rule' => array('isKurdish'),
				'message' => 'Only Kurdish-Latin alphabet is allowed.', 
                                
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave album title blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',64),
				'message' => 'At maximum 32 letters',
			),
			'minLength' => array(
				'rule' => array('minLength',2),
				'message' => 'At least 2 letters.',
			),
		),
		'artist_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Artist id error[E#]',
			),
			'maxLength' => array(
				'rule' => array('maxLength',16),
				'message' => 'Artist id error[L#Ma]',
			),
			'minLength' => array(
				'rule' => array('minLength',1),
				'message' => 'Artist id error[L#Mi]',
			),
		),
		'year' => array(
                    

			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Year must be 4 numbers.',
                                'required' => false,
                                'allowEmpty' => true,
			),
			'maxLength' => array(
				'rule' => array('maxLength',4),
				'message' => 'Year must be 4 numbers.',
                                'required' => false,
                                'allowEmpty' => true,
                        ),
			'minLength' => array(
				'rule' => array('minLength',4),
				'message' => 'Year must be 4 numbers.',
                                'required' => false,
                                'allowEmpty' => true,
                        ),
		),
            );

        

        public function beforeValidate($options = array()) {
            parent::beforeValidate($options);
             $this->data['Album']['title']=$this->sanitize($this->data['Album']['title'], "-'"); 
        }
                
     function beforeSave($options = array()) {parent::beforeSave($options);
        
        if ($this->unique==true){
           $unique=$this->getUnique();
           $this->data['Album']['unique']=$unique;
           $this->unique=$unique;   
       }
       
       $this->Artist->recursive=-1;
       
       if (!$this->id){
           
            $data=$this->data;  
            $this->artistId=$data['Album']['artist_id'];
            $artist=$this->Artist->findById($data['Album']['artist_id']);
            $this->artistUnique=$artist['Artist']['unique'];
            
       }else{
           
           
           
       }
       
      
       
       return true;
    }
         function beforeDelete($cascade = true) {
         
         parent::beforeDelete($cascade);
         $data=$this->findById($this->id);         
         $this->artistUnique=$data['Artist']['unique'];
         
         
         
         $this->bindModel(array('hasOne'=>array('trashAlbum')));
         $data=$data['Album'];
         $data['id_old']=$data['id'];
         unset($data['id']);    
         $this->trashAlbum->create();
         if ($this->trashAlbum->save($data)){return TRUE;}  else {return TRUE;}
         
     }
   
public function dublicated($check){
    if (!$check){return false;}
    $data=$this->data;
    
    $album=$this->find('first',
            array(
                'conditions'=>array(
                        'Album.title'=>$check['title'],       
                        'Album.artist_id'=>$this->artistId,
                    )
                )
            );
            if (!$album){return TRUE;}else{if($album['Album']['id']==$this->id){return true;}else{return false;}}
            
   
}

     public function findUnique($id){$unique=$this->findById($id,array('fields'=>'unique'));
        return $unique['Album']['unique'];
    }


     public function letter($artist){
         $letter=mb_substr($artist,0,1,'utf-8');
         $this->letter=$letter;
         return $letter;
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
    public function del(){
        
        if ($this->id == null){return false;}
        if ($this->saveField('deleted', 'yes')){
            
            
            $this->recursive = -1;
            $dataArray['Lyric.deleted'] = '\'yes\'';
            $conditions['Lyric.album_id'] = $this->id;
            $this->Lyric->updateAll($dataArray,$conditions);
            return true;
            
        }else{return false;}
        
    }

public function getUnique(){do {$uid=$this->_getid();    
                if(!$this->findByUnique($uid)){return $uid;
                    break;
                }
        }
        while (9==9);

    

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
 


    public function isOwnedBy($album_id = null,$user_id = null) {
       return $this->field('id', array('Album.id' => $album_id, 'Album.user_id' => $user_id)) !== false;
    }  
    
    
    
    public function isKurdish($check){
        
       $_alphabit=Configure::read('HK.KurdishAlphabetExtended');
       $_nubmers=array('0','1','2','3','4','5','6','7','8','9',' ');
       $alphabit=  array_merge($_alphabit,$_nubmers);

       $return_string = preg_replace('/\s+/', ' ',$check['title']);

       $stringArray=preg_split('/(?<!^)(?!$)/u', $return_string);


       $condition=true;
       foreach ($stringArray as $index=> $letter) {    
           if (!in_array($letter, $alphabit)){
               $condition=false;
               break;
           }
       }
       if ($condition==true){return TRUE;}else{return FALSE;}

       
    }          
            
            
            
            
}
