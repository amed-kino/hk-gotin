<?php
App::uses('AppModel', 'Model');
/**
 * Lyric Model
 *
 * @property Album $Album
 */
class Lyric extends AppModel {/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'title';
    public $artistId;
    public $artistUnique;
    public $unique = true;
    public $albumId = true;
    public $edit = array();
    public $belongsTo = array(
                    'Artist' => array(

                            'className'=>'Artist',
                            'foreignKey' => 'artist_id',                
                           // 'fields'=>array('album_counter','lyric_counter'),
                            'counterCache' => 'lyric_counter', 
                            'counterScope' => array( 'Lyric.available' => 'yes','Lyric.deleted' => 'no') 
                        ),
                    'Album' => array(
                            'className' => 'Album',
                            'foreignKey' => 'Album_id',
                            'conditions' => '',
                            'counterCache' => 'lyric_counter', 
                            'counterScope' => array( 'Lyric.available' => 'yes','Lyric.deleted' => 'no'),
                            'fields' => '',
                            'order' => ''
                    ),
                    'User' => array(
                            'className' => 'User',
                            'conditions' => '',
                            'counterCache' => 'lyric_counter', 
                            'counterScope' => array( 'Lyric.available' => 'yes','Lyric.deleted' => 'no'),                        
                            'fields' => array('id','unique','username','name','email','time_zone','birthday','infos','lyric_counter','album_counter','artist_counter'),
                            'order' => ''
                    ),            
            );
        
   
    public $validate = array(
		
        'unique' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Unique ID Issue!',
                'allowEmpty' => false,
                'required' => true,
                'on' => 'create',                
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
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
            ),
                
        'artist_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Artist id error[E#]',
                'allowEmpty' => false,
                'required' => true,
                'on' => 'create',                
                
                ),
            'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'ID Issue! [Nn#]',
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
        'album_id' => array(
            'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'message' => 'Album id error[E#]',
                    'allowEmpty' => false,
                    'required' => true, 
                    'on' => 'create',
                ),                  
            'artistsAlbum' => array(
                    'rule' => array('artistsAlbum'),
                    'message' => 'Album doen\'t belong to Artist.',
                ),

            'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'ID Issue! [Nn#]',
                ),                    
            'maxLength' => array(
                    'rule' => array('maxLength',16),
                    'message' => 'Album id error[L#Ma]',
                ),
            'minLength' => array(
                    'rule' => array('minLength',1),
                    'message' => 'Album id error[L#Mi]',
                ),
            ),
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'You can\'t leave it blank.',
                'allowEmpty' => false,
                'required' => true,                            
                ),
            'isKurdish' => array(
                'rule' => array('isKurdish'),
                'message' => 'Only Kurdish-Latin alphabet is allowed.',
                ),
            'dublicated' => array(
                'rule' => array('dublicated'),
                'message' => 'Lyric title is already exists.',
                ),
            'maxLength' => array(
                'rule' => array('maxLength',64),
                'message' => 'At maximum 64 letters',
                ),
            'minLength' => array(
                'rule' => array('minLength',2),
                'message' => 'At least 2 letters.',
                ),
            ),
        'writer' => array(
            'iseKurdish' => array(
                'rule' => array('iseKurdish'),
                'message' => 'Only Kurdish-Latin alphabet is allowed.',
                'allowEmpty' => true,
                'required' => false,     
                ),
            'maxLength' => array(
                'rule' => array('maxLength',64),
                'message' => 'At maximum 64 letters',
                ),
            'minLength' => array(
                'rule' => array('minLength',2),
                'message' => 'At least 2 letters.',
                ),
            ),
        'composer' => array(
            'iseKurdish' => array(
                'rule' => array('iseKurdish'),
                'message' => 'Only Kurdish-Latin alphabet is allowed.',
                'allowEmpty' => true,
                'required' => false,   
                ),
            'maxLength' => array(
                'rule' => array('maxLength',64),
                'message' => 'At maximum 64 letters',
                ),
            'minLength' => array(
                'rule' => array('minLength',2),
                'message' => 'At least 2 letters.',
                ),
            ),
        'echelon' => array(
                'numeric' => array(
                    'rule' => array('numeric'),
                    'message' => 'Lyric # should be numeric.',
                ),
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'message' => 'You can\'t leave it blank.',
                    'allowEmpty' => false,
                    'required' => true,
                ),                    
            ),
        'text' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'You can\'t leave it blank.',
                'allowEmpty' => false,
                'required' => true,                            
            ),                    
        ),
    );
    
    public function del(){
        
        if ($this->id == null){return false;}
        if ($this->saveField('deleted', 'yes')){return true;}else{return false;}
        
    }
            function beforeSave($options = array()) {
         
         parent::beforeSave($options);
        if ($this->unique==true){
            $unique=$this->getUnique();
            $this->data['Lyric']['unique']=$unique;
            $this->unique=$unique;
         }
        if (isset($this->data['Lyric']['title'])){$this->data['Lyric']['title']=$this->sanitize($this->data['Lyric']['title'], "-'"); }
        if (isset($this->data['Lyric']['writer'])){$this->data['Lyric']['writer']=$this->sanitize($this->data['Lyric']['writer'], "-'");}
        if (isset($this->data['Lyric']['composer'])){$this->data['Lyric']['composer']=$this->sanitize($this->data['Lyric']['composer'], "-'");}
          return true;
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

public function getUnique(){
    
    
    
    do {
    
    $uid=$this->_getid();    
        if(!$this->findByUnique($uid)){return $uid;
            break;
        }
    }
        while (9==9);

    

}
public function artistsAlbum($check){

    $data=$this->data;
        
    if (!isset($data['Lyric']['artist_id'])){
         $this->data['Lyric']['artist_id']=$this->artistId;
    }
    
     
//    var_dump($data);
    $album=$this->Album->findById($check);
    
    if (!$album){return FALSE;
        
    }else{if ($data['Lyric']['artist_id']==$album['Album']['artist_id']){return TRUE;}else{return FALSE;}
    }
    
        
}
        
        
public function dublicated($check){
    $data=$this->data;
    if (!$check){return false;
    }else{

        $lyric=$this->find('first',array(
            'conditions'=>array(
                'Lyric.album_id'=>$this->albumId,
                'Lyric.title'=>$check),
        ));
        
        if (!$lyric){return true;
        }else{
            if ($lyric['Lyric']['id']==$this->id){return true;}else{return false;}
        }
    }
}          

    public function isOwnedBy($lyric_id = null,$user_id = null) {
       return $this->field('id', array('Lyric.id' => $lyric_id, 'Lyric.user_id' => $user_id)) !== false;
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
    
       public function iseKurdish($_check){

       $_alphabit=Configure::read('HK.KurdishAlphabetExtended');
       $_nubmers=array('0','1','2','3','4','5','6','7','8','9',' ','(',')','-','/','\\',',','.','&',';');
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
    
    
    
    function inChain($editorId = null, $editors = null){
        
      if ($editorId == null || $editors == null){return false;} 
      
      $editorsArray =  explode(',',$editors);
      
      if (in_array($editorId, $editorsArray)){return true;}else{return false;}
    
    }    
    
    
    
    public function addEditor($lyricId=null,$editorId=null){
        if ($lyricId==null || $editorId==null){return false;}
        
        $lyric = $this->findById($lyricId,array('id','editors'));
        if (empty($lyric)){return false;}
        
        $this->id = $lyric['Lyric']['id'];
        $editors = $lyric['Lyric']['editors'];
        
        
        if ($editors == null){
            $editors = $editorId;
            $lyric['Lyric']['editors'] = $editors;
            if ($this->save($lyric,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}
        }else{
            if (!$this->inChain($editorId,$editors)){
        
                $editors .= ','.$editorId;
                $lyric['Lyric']['editors'] = $editors;
            
                if ($this->save($lyric,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}

            }else{
                return true;
            }
            
        }
       

    }
    
    
    
    public function addTag($lyricId=null,$editorId=null){
        if ($lyricId == null || $editorId == null){return false;}
        
        $lyric = $this->findById($lyricId,array('id','editors'));
        if (empty($lyric)){return false;}
        
        $this->id = $lyric['Lyric']['id'];
        $editors = $lyric['Lyric']['editors'];
        
        
        if ($editors == null){
            $editors = $editorId;
            $lyric['Lyric']['editors'] = $editors;
            if ($this->save($lyric,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}
        }else{
            if (!$this->inChain($editorId,$editors)){
        
                $editors .= ','.$editorId;
                $lyric['Lyric']['editors'] = $editors;
            
                if ($this->save($lyric,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}

            }else{
                return true;
            }
            
        }
       

    }
    
    
    public function removeEditor($lyricId=null,$editorId=null){
        if ($lyricId==null || $editorId==null){return false;}
        
        $lyric = $this->findById($lyricId,array('id','editors'));
        if (empty($lyric)){return false;}
        
        $this->id = $lyric['Lyric']['id'];
        $editors = $lyric['Lyric']['editors'];
        
        
        if ($editors != null  && !$this->inChain($editorId,$editors)){
            
            // it needs to be set. 
            $editors .= ','.$editorId;
                $lyric['Lyric']['editors'] = $editors;
            
                if ($this->save($lyric,array('validate' => false, 'callbacks' => false))){return true;}else{return false;}


            
        }else{
            
                return false;
                
            }
            
        }
        

    }
