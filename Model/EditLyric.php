<?php
App::uses('AppModel', 'Model');



class EditLyric extends AppModel {


    public $edit = array();
    public $belongsTo = array(

                        'User' => array(
                            'className' => 'User',
                            'fields' => array('User.id','User.unique','User.name',),
                            ),

                        'Lyric' => array(
                                'className'=>'Lyric',
                                'foreignKey' => 'lyric_id',                
                                // 'fields'=>array('album_counter','lyric_counter'),
                                'counterCache' => 'lyric_edit_counter', 
                            ),
                    );

    function beforeSave($options = array()) {

        parent::beforeSave($options);

        if(isset($this->data['EditLyric']['title'])){$this->data['EditLyric']['title']=$this->sanitize($this->data['EditLyric']['title'], "-'");}
        if(isset($this->data['EditLyric']['writer'])){$this->data['EditLyric']['writer']=$this->sanitize($this->data['EditLyric']['writer'], "-'");}
        if(isset($this->data['EditLyric']['composer'])){$this->data['EditLyric']['composer']=$this->sanitize($this->data['EditLyric']['composer'], "-'");}
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


    

    public function saveEdit($lyric, $user_id = null, $type = null){

        if ($type=='current'){
            
            $type='current';
            $status = 'accepted';
        }else{
            
            $type='edit';
            $user_id = $user_id ;
            $status = 'pending';
            
        }

        $editData['lyric_id'] = $lyric['id'];
        $editData['title']    = $lyric['title'];
        $editData['writer']   = $lyric['writer'];
        $editData['composer'] = $lyric['composer'];
        $editData['echelon']  = $lyric['echelon'];
        $editData['text']     = $lyric['text'];
        $editData['source']   = $lyric['source'];
        $editData['user_id']  = $user_id;
        $editData['type']     = $type;
        $editData['status']   = $status;
    
        if ($this->save($editData)){
            
            return true;
            
        }else{return false;}
        
    }



    

    public function saveOrginal($lyric){
        
        $orginalData['lyric_id'] = $lyric['id'];
        $orginalData['title']    = $lyric['title'];
        $orginalData['writer']   = $lyric['writer'];
        $orginalData['composer'] = $lyric['composer'];
        $orginalData['echelon']  = $lyric['echelon'];
        $orginalData['text']     = $lyric['text'];
        $orginalData['source']   = $lyric['source'];
        $orginalData['created']  = $lyric['created'];
        $orginalData['modified'] = null;
        $orginalData['user_id']  = $lyric['user_id'];
        $orginalData['type']     = 'orginal';
        $orginalData['status']   =  'accepted';

        
        if ($this->save($orginalData)){return true;}else{return false;}
        
    }
    public function setCurrent($id){
        
       $this->recursive = -1;
       $currentLyric = $this->find('first',array(
           'conditions' => array('EditLyric.id' => $id),
           'fields' => array('id','lyric_id','type')
       ));


       if(!empty($currentLyric)){
            $editId = $currentLyric['EditLyric']['id'];
            $lyricId = $currentLyric['EditLyric']['lyric_id'];
            $lyricType = $currentLyric['EditLyric']['type'];
       }else{die('SET_CURRENT_ERROR_EMPTY_RETURNMENT');}



        $conditions = array(  
            
                'EditLyric.lyric_id' => $lyricId,
                'EditLyric.type !=' => 'orginal'
            );
        
        $this->recursive = -3;
        
        if (!($this->updateAll(array('EditLyric.type' => '\'edit\''),$conditions))){die('SET_CURRENT_ERROR_UPDATE_TO_EDIT');}

       
       if ($lyricType != 'orginal'){
           $this->id = $editId;
            if (!($this->save(array('EditLyric' => array('type' => 'current','status' => 'accepted'))))){die('SET_CURRENT_ERROR_SAVE_CURRENT');}
       }
      
     return true;

    }
    
    public function setDeclined($id){

       $this->recursive = -1;
       $currentLyric = $this->find('first',array(
           'conditions' => array('EditLyric.id' => $id),
           'fields' => array('id','lyric_id','type')
       ));

       if(!empty($currentLyric)){
            $editId = $currentLyric['EditLyric']['id'];
            $lyricId = $currentLyric['EditLyric']['lyric_id'];
            $lyricType = $currentLyric['EditLyric']['type'];
       }else{die('SET_DECLINED_ERROR_EMPTY_RETURNMENT');}

       

        $conditions = array(  
           
                'EditLyric.lyric_id' => $lyricId,
                'EditLyric.type !=' => 'orginal'
            );       
       if ($lyricType != 'orginal'){
           $this->id = $editId;
            if (!($this->save(array('EditLyric' => array('status' => 'declined'))))){die('SET_DECLINED_ERROR_SAVE_DECLINED');}
       }else{return FALSE;}

    }



}



