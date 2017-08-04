<?php
App::uses('AppController', 'Controller');
App::uses('HKComponent', 'Component');


/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AjaxController extends AppController {
    
    
    public $autoRender=false;
    public $components = array();

    
    private $user;
    private $group;
     
    
    public function beforeFilter() {
        
        parent::beforeFilter();
        $this->Auth->allow('albumsList','emailExists','userExists','margin_contact');
        if (!$this->request->is('ajax')){
           throw new NotFoundException(__('Access Error!')); 
        }
        
        $this->loadModel('User');
        $user = $this->user = $this->Auth->user();

        $group=$this->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        
    }
    
    

    public function index() {    
        die();
        //Silence is golden.
    }

     function changepassword($unique=null){
         
//if user has User update authority he could change so ever.
         if ($unique == null) {return false;}
         if ($unique != $this->Session->read('Auth.User.unique')){
             if (!$this->Acl->check($this->group,'User','update')){return false;}else{
                 // Here is Super user place
                 // it is not ready yet.
             }
         }else{
             
             $this->loadModel('User');
             $user = $this->User->findByUnique($unique); 
             
            if (!isset($this->request->data['old'])){return false;}else{

                    $oldPass = $this->request->data['old'];

            }
            if (!isset($this->request->data['new'])){return false;}else{
                if (strlen($this->request->data['new'])<6){
                    return false;
                }else{
                    $newPass = $this->request->data['new'];
                }
                
                
            }
            
            $storedHash = $user['User']['password'];
            $newHash = Security::hash($oldPass, 'blowfish', $storedHash);
            $correct = $storedHash == $newHash;
            
            if ($correct === false){
                return false;
            }else{
                // Here is safe capsule for changing password.
                
                $this->User->id = $user['User']['id'];
                $this->User->unique = false;
                
                $dataArray['User']['password'] = $newPass;
               
                if ($this->User->save($dataArray)){return true;}else{return false;}
            }
            
            
           
             
         }
    }
    
     function changerank($unique = null, $rank = null){
        
        if ($rank == null || !is_numeric($rank) || $rank<1 || $rank>5) {
            
            echo 'error';
            return false;
            
        }
        
        $rank = 6 - $rank;
        if (!$this->Acl->check($this->group,'User','read')) {
            
            return false;
            
        }
        
        if ($unique == null) {return false;}
        $this->loadModel('User');
        $user = $this->User->findByUnique($unique);
        if (empty($user)){return false;}
        
        $changerRank = $this->Session->read('Auth.User.group_id');
        $userRank = $user['User']['group_id'];
        
        
        // check if the entry match administration rules.
        
        //backward promotion.
        if ($userRank<=$rank){
            
//            echo 'backdown';
            return false;
            
        }
        //over-shoulder promotion.
        if ($changerRank>=$rank){
            
//            echo 'overshoulder';
            return false;
            
        }
        
        
//        $dataArray = array(
//            'userRank' =>$userRank,
//            'changerRank' =>$changerRank,
//        );
//        var_dump($dataArray);
        
        $this->User->id = $user['User']['id'];
        if ($this->User->saveField('group_id',$rank)){
            
//                $from = $this->Auth->user('id');
//                $to = $user['User']['id'];
//                $noteId = 35;
//                $marks = array('lyricUnique' => $lyric['Lyric']['unique'],'lyricTitle' => $lyric['Lyric']['title'],'artistName' => $lyric['Artist']['name']);
//                $this->HK->notificate($from,$to,$noteId,$marks);
//                
                
            return true;
            
        }else{
            return false;
            
        }
        
        
    }
    
            
            
            
    function messages($user_unique=null){

        if(!isset($user_unique)){return null;}
        
        $userCurrent=$this->Auth->user('unique');
        $userCurrentId=$this->Auth->user('id');
        if ($user_unique==$userCurrent){return null;}
        
        $this->loadModel('User');
        $user=$this->User->findByUnique($user_unique);
        
        if (empty($user)){return null;}
        $userId = $user['User']['id'];
        $userName = $user['User']['name'];
        
        $this->loadModel('Message');
        $data = $this->Message->find('all',array(
                                                 'conditions' =>  array (
                                                                    'OR' => array(
                                                                        array('Message.user_1' => $userCurrentId,'Message.user_2' =>$userId),
                                                                        array('Message.user_2' => $userCurrentId,'Message.user_1' =>$userId),
                                                                            )
                                                                    ),
                                                  'order' => 'Message.id ASC'
                                                    )
                                        );
//            var_dump($dataArray);

        $dataArray['username']=$userName;
        $dataArray['data']=$data;
        echo json_encode($dataArray);
    }
    
    private function savefile_($unique, $file){
        
        $lyric = $this->Lyric->findByUnique($unique);
        
        if (empty($lyric)){return false;}
        
        $this->Lyric->id = $lyric['Lyric']['id'];
        if ($this->Lyric->saveField('file',$file)){
            return true;
        }else{
            return false;
        }
    }
    
    
    function savefile($unique = null){
       
        
        
        $data = $this->request->data;
        
        if (empty($data)){return null;}
        
        $this->loadModel('Lyric');
        $user = $this->user =  $this->Auth->user();
        $group = $this->Lyric->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        if (!$this->Acl->check($this->group,'Lyric','delete')){return false;}

        $return = array();
        if ($data['fileUrl'] == ' '){
            
            if ($this->savefile_($data['fileUnique'], null)){
                $return['error'] = false;
            }else{
                $return['error'] = true;
                $return['message'] = __('The file cannot be saved.');
            }
            
        }else if($this->HK->fileExisted($data['fileUrl'],'mp3') == false){
            
            $return['error'] = true;
            $return['message'] = __('The file is not existed.');
            
        }else{
            
            if ($this->savefile_($data['fileUnique'], $data['fileUrl'])){
                $return['error'] = false;
            }else{
                $return['error'] = true;
                $return['message'] = __('The file cannot be saved.');
            }
        }
        
        echo json_encode($return);
        
        
        
        
        
        
    }
    function song($unique=null){
       
        if(!isset($unique)){return null;} 
        
        $this->loadModel('Lyric');
        $lyric=$this->Lyric->findByUnique($unique,array(
            'Lyric.unique',
            'Lyric.title',
            'Lyric.file',
            'Album.title',
            'Album.year',
            'Artist.name',
        ));
        
        if (empty($lyric)){return null;}


        echo json_encode($lyric);
    }
    function lyric($unique=null){
        
        if(!isset($unique)){return null;} 
        $this->loadModel('Lyric');
        $lyric=$this->Lyric->findByUnique($unique,array(
            'Lyric.unique',
            'Lyric.title',
            'Lyric.writer',
            'Lyric.composer',
            'Lyric.echelon',
            'Lyric.text',
            'Lyric.source',
            'Lyric.created',
            'Lyric.lyric_edit_counter',
            'Album.unique',
            'Album.title',
            'Album.year',
            'Artist.unique',
            'Artist.name',
            'User.unique',
            'User.name',
        ));
        if (empty($lyric)){return null;}


        echo json_encode($lyric);
    }
    
    
    
    function acceptLyric($unique=null){

        if (!$this->Acl->check($this->group,'Lyric','update')){return false;}
        $this->loadModel('Lyric');
        $user = $this->user=$this->Auth->user();
        $group = $this->Lyric->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        if(!isset($unique)){return null;}
        
        $lyric=$this->Lyric->findByUnique($unique);
        
        if (empty($lyric)){return null;}
        
        $this->Lyric->id = $lyric['Lyric']['id'];
        if ($this->Lyric->saveField('available','yes')){
            
            // notificarion 
            if (!$this->Lyric->isOwnedBy($lyric['Lyric']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $lyric['Lyric']['user_id'];
                $noteId = 35;
                $marks = array('lyricUnique' => $lyric['Lyric']['unique'],'lyricTitle' => $lyric['Lyric']['title'],'artistName' => $lyric['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    
    
    function acceptAlbum($unique=null){

        if (!$this->Acl->check($this->group,'Album','update')){return false;}       
        $this->loadModel('Album');
        $user = $this->user=$this->Auth->user();
        $group = $this->Album->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        if(!isset($unique)){return null;}
        
        $album=$this->Album->findByUnique($unique);
        
        if (empty($album)){return null;}
        
        $this->Album->id = $album['Album']['id'];
        if ($this->Album->saveField('available','yes')){

            // notificarion 
            if (!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $album['Album']['user_id'];
                $noteId = 25;
                $marks = array('albumUnique' => $album['Album']['unique'],'albumTitle' => $album['Album']['title'],'artistName' => $album['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    
    function acceptArtist($unique=null){

        if (!$this->Acl->check($this->group,'Artist','update')){return false;}       
        $this->loadModel('Artist');
        $user = $this->user=$this->Auth->user();
        $group = $this->Artist->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        if(!isset($unique)){return null;}
        
        $artist=$this->Artist->findByUnique($unique);
        if (empty($artist)){return null;}
        
        $this->Artist->id = $artist['Artist']['id'];
        if ($this->Artist->saveField('available','yes')){
            
            // notificarion 
            if (!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $artist['Artist']['user_id'];
                $noteId = 15;
                $marks = array('artistUnique' => $artist['Artist']['unique'],'artistName' => $artist['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    
    
    function deleteLyric($unique=null){

        $this->loadModel('Lyric');
        $user = $this->user =  $this->Auth->user();
        $group = $this->Lyric->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        if (!$this->Acl->check($this->group,'Lyric','delete')){return false;}
        if(!isset($unique)){return null;}
        
        $lyric=$this->Lyric->findByUnique($unique);
        if (empty($lyric)){return null;}
        
        $this->Lyric->id = $lyric['Lyric']['id'];
        if ($this->Lyric->saveField('deleted','yes')){
                       
            // notificarion 
            if (!$this->Lyric->isOwnedBy($lyric['Lyric']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $lyric['Lyric']['user_id'];
                $noteId = 36;
                $marks = array('lyricUnique' => $lyric['Lyric']['unique'],'lyricTitle' => $lyric['Lyric']['title'],'artistName' => $lyric['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    function deleteAlbum($unique=null){

        $this->loadModel('Album');
        $user = $this->user=$this->Auth->user();
        $group = $this->Album->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        if (!$this->Acl->check($this->group,'Album','delete')){return false;}
        if(!isset($unique)){return null;}
        
        $album=$this->Album->findByUnique($unique);
        if (empty($album)){return null;}
        
        $this->Album->id = $album['Album']['id'];
        if ($this->Album->saveField('deleted','yes')){
            
            // notificarion 
            if (!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $album['Album']['user_id'];
                $noteId = 26;
                $marks = array('albumUnique' => $album['Album']['unique'],'albumTitle' => $album['Album']['title'],'artistName' => $album['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    function deleteArtist($unique=null){

        $this->loadModel('Artist');
        $user = $this->user=$this->Auth->user();
        $group = $this->Artist->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
        
        if (!$this->Acl->check($this->group,'Artist','delete')){return false;}
        if(!isset($unique)){return null;}
        
        $artist=$this->Artist->findByUnique($unique);
        if (empty($artist)){return null;}
        
        $this->Artist->id = $artist['Artist']['id'];
        if ($this->Artist->saveField('deleted','yes')){
            
            // notificarion 
            if (!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $artist['Artist']['user_id'];
                $noteId = 16;
                $marks = array('artistUnique' => $artist['Artist']['unique'],'artistName' => $artist['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }
            
            return true;
            
        }else{
            
            return false;
            
        }
    }
    
    
    
    function message($user_unique=null,$message=null){
        
        $message =  trim($message);
      
        if(!isset($user_unique) || !isset($message)){return null;}
        
        $userCurrent=$this->Auth->user('unique');
        $userCurrentId=$this->Auth->user('id');
        
        if ($user_unique==$userCurrent){return null;}
        
        $this->loadModel('User');
        $user=$this->User->findByUnique($user_unique);
        
        if (empty($user)){return null;}
        
        $userId = $user['User']['id'];
        
        $this->loadModel('Message');
        
        $dataArray=array();
        $dataArray['Message']['user_1']=$userCurrentId;
        $dataArray['Message']['user_2']=$userId;
        $dataArray['Message']['message']=h($message);
        
        if ($this->Message->save($dataArray)){return true;}else{return false;}

        
    }
    
    
    public function margin_contact($user_unique = null){
        
          
        // Check if the message is to specfified person.
        $userId = 0;
        $returnment = null;
        if ($user_unique != null || $user_unique != ''){
            $section = 'private';
            $this->loadModel('User');
            $user = $this->User->findByUnique($user_unique);
            if (empty($user)){return null;}
        }
        
       
        
        // Extract array from request
        if (isset($this->request->data['MCName'])){
            $name = $this->request->data['MCName'];
        }else{
            $name = 'unkown';
        }
        
        if (isset($this->request->data['MCEmail'])){
            $email = $this->request->data['MCEmail'];
        }else{
            $email = 'unkown';
        }
        
        if (isset($this->request->data['MCDestination'])){
            $destination = $this->request->data['MCDestination'];
        }else{
            $destination = 'unkown';
        }
       
        if (isset($this->request->data['MCText'])){
            $text = $this->request->data['MCText'];
            $text = trim($text);
            if ($text == '' || strlen($text)<3){
                $returnment['text'] = __('You have to fill text.');
            }
        }
        else{
            $returnment['text'] = __('You have to fill text.');
        }

        
        // Check if there is Errors happend,
        if ($returnment != null){
            echo json_encode($returnment);
        }else{
            $marks = $this->HK->marks(array(
                        'name' => h($name),
                        'email' => h($email),
                        'destination' => h($destination),
                        'port' => $_SERVER['REMOTE_PORT'],
                        'ip' => $_SERVER['REMOTE_ADDR']
                    )); 


            $dataArray=array();
            $dataArray['Message']['user_1'] = 0;
            $dataArray['Message']['user_2']= $userId;
            $dataArray['Message']['message'] = h($text);
            $dataArray['Message']['marks'] =
            $dataArray['Message']['marks'] = $marks;
                      
            $this->loadModel('Message');
            if ($this->Message->save($dataArray)){return true;}else{return false;}
        }
        
       
    }

    public function userExists() {
        
        $username =  trim(strtolower($this->request->data['username']));
        
        if ($username==NULL){
            $dataArray['args']=FALSE;
            $dataArray['available']=FALSE;
            echo json_encode($dataArray);
        
            // If $userename is set.
        }else{
            
            // If the $username is alphanumeric.
            if (ctype_alnum($username) && strlen($username)>=4 && strlen($username)<=24){
                
                $dataArray['args']=TRUE;

                $this->loadModel('User');
                $this->User->recursive=-1;
                $username=$this->User->findByUsername($username,array('id','unique','username','name'));
                    
                    if ($username==NULL) {
                        $dataArray['available']=TRUE;
                    }else{
                        $dataArray['available']=FALSE;
                    }
            }else{
                
                $dataArray['args']=FALSE;
                $dataArray['available']=FALSE;
            }
            
            echo json_encode($dataArray);
        }
        
        die();
    }
    
    public function emailExists() {
        
        $email=  trim(strtolower($this->request->data['email']));
        
        if ($email==NULL){
            $dataArray['args']=FALSE;
            $dataArray['available']=FALSE;
            echo json_encode($dataArray);
        
            // If $email is set.
        }else{
            
            // If the $email is alphanumeric.
             
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $dataArray['args']=TRUE;

                $this->loadModel('User');
                $this->User->recursive=-1;
                $email=$this->User->findByEmail($email,array('id','unique','username','name'));
                    
                    if ($email==NULL) {
                        $dataArray['available']=TRUE;
                    }else{
                        $dataArray['available']=FALSE;
                    }
            }else{
                
                $dataArray['args']=FALSE;
                $dataArray['available']=FALSE;
            }
            
            echo json_encode($dataArray);
        }
        
        die();
    }
    
    public function albumsList($unique){
        if ($unique==null || $unique==""){
            // Passed Arguments is empty
            $dataArray['artist']=false;
            $dataArray['albums']=false;
            
        }else{
            $this->loadModel('Artist');
            $this->Artist->recursive=-1;
            $artist=$this->Artist->findByUnique(h($unique));
            if ($artist==null || empty($artist) || $artist==''){
                $dataArray['artist']=false;
                $dataArray['albums']=false;
            }else{

                $dataArray['artist']=true;
                
                $this->loadModel('Album');
                $this->Album->recursive=-1;
                $albums=$this->Album->find('all',
                        array(
                            'conditions' => array('available' => 'yes','Album.artist_id' => $artist['Artist']['id']),
                            'order' => array('year DESC'),
                            'fields' => array('unique','title','year'),
                            )
                        );
                
                if ($albums==null || empty($albums) || $albums==' '){
                    $dataArray['albums']=false;
                }else{
                    
                    
                    $dataArray['albums']=true;

                    $_albums=array();
                    foreach ($albums as $key => $value) {
                        $_albums[$value['Album']['unique']]=$value['Album']['year'].' - '.$value['Album']['title'];
                    }
                    $dataArray['data']=$_albums;
                    
                }
                        
            }
        }
            
        
        $this->response->body(json_encode($dataArray));
        
        }
        
}
