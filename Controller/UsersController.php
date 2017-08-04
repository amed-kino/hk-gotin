<?php
App::uses('AppController', 'Controller');
App::uses('HKComponent', 'Component');
App::uses('AccessComponent', 'Component');

/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {
    
    
    private $user;
    private $group;
     

    public $helpers = array('Paginator');    
    public $components = array('HybridAuth','Paginator');
    
    public function beforeFilter() {
        
        parent::beforeFilter();
        $accessArray=array('login','signup','profile','property','completesignup','profile','install','breakesession','social_login','social_endpoint','userslist','recovery');
        $this->Auth->allow($accessArray);
        
        
        if ($this->Session->check('Auth.User')){
        $user=$this->user=$this->Auth->user();
        $group=$this->User->Group;
        $group->id = $user['Group']['id'];
        $this->group=$group;
        }else{
            
        }
   
    // set cookie options
    $this->Cookie->httpOnly = true;
     
    if (!$this->Auth->loggedIn() && $this->Cookie->read('rememberMe')) {
         $cookie = $this->Cookie->read('rememberMe');
 
             $this->loadModel('User'); // If the User model is not loaded already
         $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $cookie['username'],
                    'User.password' => $cookie['password']
                )
         ));
     
         if ($user && !$this->Auth->login($user['User'])) {
                $this->redirect('/users/logout'); // destroy session & cookie
         }
     }
 
     
    }
    
    public function flushAll(){
        
        $cachePaths = array('js','css','menus','views','persistent','models'); 
        foreach($cachePaths AS $config){ 
            
            Cache::config($config, array('path' => CACHE.$config.DS, 'prefix'=>'', 'engine'=>'File')); 
            if ( Cache::clear(false, $config) ){
                echo 'Done :)<br/>';
            }else{
                echo 'notDone :(<br/>';
            }
        } 
  
  
        
        die();
    }
    public function social_login($provider) {

       
        if($this->HybridAuth->connect($provider) ){
            $this->_successfulHybridAuth($provider,$this->HybridAuth->user_profile);
        }else{

            // error
            $this->Session->setFlash($this->HybridAuth->error);
            $this->redirect($this->Auth->loginAction);
        }
        
    }
    public function social_endpoint() {

    $this->HybridAuth->processEndpoint();
}
    
    private function _successfulHybridAuth($provider, $incomingProfile){
 
    // #1 - check if user already authenticated using this provider before
    $this->User->recursive = 1;
    $existingProfile = $this->User->find('first', array(
        'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'], 'social_network_name' => $provider)
    ));

    if ($existingProfile) {
        // #2 - if an existing profile is available, then we set the user as connected and log them in
        $user = $this->User->find('first', array(
            'conditions' => array('User.id' => $existingProfile['User']['id'])
        ));
        

        $user['User']['Group'] = $user['Group'];
        unset($user['Group']);
        $user = $user['User'];
        
        $this->_doSocialLogin($user,true);
        
    } else {
         
        // New profile.
        if ($this->Auth->loggedIn()) {
            die('You are loggedin.');
        } else {
            
            
            
            // no-one logged and no profile, must be a registration.
            $user = $this->User->createFromSocialProfile($incomingProfile);
            $incomingProfile['SocialProfile']['user_id'] = $user['User']['id'];
            $this->User->save($incomingProfile);
 
            
            
            // After saving the user, must login normally.

            
                    $this->User->recursive = 1;
                    $savedProfile = $this->User->find('first', array(
                        'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'], 'social_network_name' => $provider)
                    ));
                
                    if ($savedProfile) {
                        $savedUser_c = $this->User->find('first', array(
                            'conditions' => array('User.id' => $savedProfile['User']['id'])
                        ));


                        $savedUser_c['User']['Group'] = $savedUser_c['Group'];
                        unset($savedUser_c['Group']);
                        $savedUser = $savedUser_c['User'];

                        $this->_doSocialLogin($savedUser,true);
                    } else {
                        
                        $this->redirect(array('controller' => 'users', 'action' => 'logout'));
                        
                    }
        }
    }   
}
private function _doSocialLogin($user, $returning = false) {
    
    if ($this->Auth->login($user)){
        
        if($returning){
//            $this->Session->setFlash(__('Welcome back, '. $this->Auth->user('username')));
        } else {
//            $this->Session->setFlash(__('Welcome to our community, '. $this->Auth->user('username')));
        }
        $this->loginProcedures();
        $this->redirect($this->Auth->loginRedirect);
         
    } else {
        $this->Session->setFlash(__('Unknown Error could not verify the user.'. $this->Auth->user('username')),'default',array(),'flashError');
    }
}

    public function breakesession(){
        if ($this->Session->destroy()){echo "True!";}
        die();
    }

    private function premissionsArray(){

        if ($this->Session->check('Auth.User')){
            

        $user = $this->Auth->user();
        $group=$this->User->Group;
        $group->id=$user['Group']['id'];
        $dataArray=array(
        
            'Artist'=>array(
                $this->Acl->check($group,'Artist','create'),
                $this->Acl->check($group,'Artist','read'),
                $this->Acl->check($group,'Artist','update'),
                $this->Acl->check($group,'Artist','delete'),
            ),
            'Album'=>array(
                $this->Acl->check($group,'Album','create'),
                $this->Acl->check($group,'Album','read'),
                $this->Acl->check($group,'Album','update'),
                $this->Acl->check($group,'Album','delete'),
            ),
            'Lyric'=>array(
                $this->Acl->check($group,'Lyric','create'),
                $this->Acl->check($group,'Lyric','read'),
                $this->Acl->check($group,'Lyric','update'),
                $this->Acl->check($group,'Lyric','delete'),
            ),
            'User'=>array(
                $this->Acl->check($group,'User','create'),
                $this->Acl->check($group,'User','read'),
                $this->Acl->check($group,'User','update'),
                $this->Acl->check($group,'User','delete'),
            ),
            'Request'=>array(
                $this->Acl->check($group,'Request','create'),
                $this->Acl->check($group,'Request','read'),
                $this->Acl->check($group,'Request','update'),
                $this->Acl->check($group,'Request','delete'),
            )
    );
        $this->Session->write('Auth.Acl',$dataArray);


    }
    }
            
    function install(){   
        
    if($this->Acl->Aro->findByAlias("Super")){ 
        $this->redirect('/'); 
    } 
    $aro = new aro(); 
  
    $aro->create(); $aro->save(array( 'model' => 'Group', 'foreign_key' => 1, 'parent_id' => null, 'alias' => 'Super')); 
    $aro->create(); $aro->save(array( 'model' => 'Group', 'foreign_key' => 2, 'parent_id' => null, 'alias' => 'Admin')); 
    $aro->create(); $aro->save(array( 'model' => 'Group', 'foreign_key' => 3, 'parent_id' => null, 'alias' => 'Member')); 
    $aro->create(); $aro->save(array( 'model' => 'Group', 'foreign_key' => 4, 'parent_id' => null, 'alias' => 'User')); 
    $aro->create(); $aro->save(array( 'model' => 'Group', 'foreign_key' => 5, 'parent_id' => null, 'alias' => 'Suspended')); 
    
    $aco = new Aco();
    
    $aco->create(); $aco->save(array('model' => 'User',   'foreign_key' =>null, 'parent_id' =>null, 'alias' =>'User'));
    $aco->create(); $aco->save(array('model' => 'Artist', 'foreign_key' =>null, 'parent_id' =>null, 'alias' =>'Artist'));
    $aco->create(); $aco->save(array('model' => 'Album',  'foreign_key' =>null, 'parent_id' =>null, 'alias' =>'Album'));
    $aco->create(); $aco->save(array('model' => 'Lyric',  'foreign_key' =>null, 'parent_id' =>null, 'alias' =>'Lyric'));
    $aco->create(); $aco->save(array('model' => 'Request',  'foreign_key' =>null, 'parent_id' =>null, 'alias' =>'Request'));
  

    $this->Acl->allow('Super', 'User',    '*');
    $this->Acl->allow('Super', 'Artist',  '*');
    $this->Acl->allow('Super', 'Album',   '*');
    $this->Acl->allow('Super', 'Lyric',   '*');
    $this->Acl->allow('Super', 'Request', '*');

    $this->Acl->allow('Admin', 'User',   array('create', 'read', 'update',)); 
    $this->Acl->allow('Admin', 'Artist', array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Admin', 'Album',  array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Admin', 'Lyric',  array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Admin', 'Request',array('read','delete')); 

    $this->Acl->allow('Member', 'User',   array('create', 'read',)); 
    $this->Acl->allow('Member', 'Artist', array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Member', 'Album',  array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Member', 'Lyric',  array('create', 'read', 'update', 'delete')); 
    $this->Acl->allow('Member', 'Request',array('read','delete'));

    $this->Acl->allow('User', 'Artist', array('create', 'read', 'update'));
    $this->Acl->allow('User', 'Album',  array('create', 'read', 'update'));
    $this->Acl->allow('User', 'Lyric',  array('create', 'read', 'update'));
    $this->Acl->allow('User', 'Request',array('read'));

    $this->Acl->allow('Suspended', 'Artist', array('create', 'read'));
    $this->Acl->allow('Suspended', 'Album',  array('create', 'read'));
    $this->Acl->allow('Suspended', 'Lyric',  array('create', 'read'));
    $this->Acl->allow('Suspended', 'Request',array('read'));

}
    public function index(){
        
        $option = array(
            
            'fields' => array(
                'User.unique',
                'User.name',
                'User.lyric_counter',
                'User.album_counter',
                'User.artist_counter',
               
            ),
            'order' => 'User.name',
            'conditions' => array('User.private' => 'no'),
            
        );
        $users = $this->User->find('all',$option);
        
        $this->set('users',$users);
        $this->set('title', __('Users'));
        
        
    }
    
    public function userslist($letter = null) {
        
        
        if (!$this->Session->check('Auth.User')){
            $authorityCheck = false;
            
        }else{
            
            $authorityCheck =   ($this->Acl->check($this->group,'User','create')) || 
                                ($this->Acl->check($this->group,'User','read'))   ||
                                ($this->Acl->check($this->group,'User','update')) ||
                                ($this->Acl->check($this->group,'User','delete')) ;
        }
        
        if (isset($letter)){$letterCheck = $this->HK->isKurdish($letter);}else{$letterCheck = true;}

        if(!$authorityCheck || !$letterCheck){throw new NotFoundException(__('Not found'));}
                
        // if the letter is selected.
        if (isset($letter) || $letter != null){
                        
            $this->User->recursive = 0;
            $users= $this->User->find('all',array(
                'conditions' => array('User.name LIKE' => $letter.'%'),
//                'conditions' => array('User.social_network' => 'no'),
//                'conditions' => array('not' => array('name' => 'user')),
                'fields'=>array(
                            'User.id',
                            'User.unique',
                            'User.name',
                            'User.username',
                            'User.group_id',
                            'User.lyric_counter',
                            'User.album_counter',
                            'User.artist_counter',
                            'User.active',
                    ),
                'recursive'=>-1,
                'order' => 'User.username ASC',
            ));
            
            $this->set('letter',$letter);            
            
            if(empty($users)){
                
                $this->set('title',__('Users'));
                $this->render('userslist_empty');
                
                
            }else{
                $this->set('title',__('Users').'-'.$letter);
                $this->set('users',$users);
                $this->render('userslist');
            }

        }else{
            $this->set('title',__('Users'));
            $this->render('userslist_start');
        }
        
        
        
    }
    

    public function login(){
        
        if ($this->request->is('ajax')){
            $this->loginAjax();
        }else{
            $this->loginNormal();
        }
        
    }
    private function loginAjax(){
            
        
//        sleep(2);
        $data = $this->request->data;
        $returnment = false;
//        
//       
        if($this->Session->check('Auth.User')){
            $returnment['refresh'] = true;
        }else{
            if ($data['User']['username'] != '' && $data['User']['password'] != ''){
                $this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);

                
                if ($this->Auth->login()){
                                            
                    $this->loginProcedures();
                                            
                    $returnment['error'] = false;
                    $returnment['message'] =  __('You are logged in now.');
                    $returnment['refresh'] = true;
                    
                }else{
                    $returnment['error'] = true;
                    $returnment['message'] =  __('Username or password is invalid.');
                    $returnment['refresh'] = false;
                }
            }
        }
        

        echo json_encode($returnment);
        die();
        
    }
    
    private function loginRemember(){
        
                        
        // After what time frame should the cookie expire

//    $cookieTime = "12 months"; // You can do e.g: 1 week, 17 weeks, 14 days
//
//    // remove "remember me checkbox"
//    unset($this->request->data['User']['rememberMe']);
//
//    // hash the user's password
//    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
//
//    // write the cookie
//    $this->Cookie->write('rememberMe', $this->request->data['User'], true, $cookieTime);
    }
    private function loginNormal(){

        $this->set('title',__('Login'));
            
        
        // Check if the user is logged in.
        // If not.
        if(!$this->Session->check('Auth.User')){
            
            // if the request is sent.
            if($this->request->is('post')) {
                if (isset($this->request->data['User']['username'])){$this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);}
                // if the login is successful.
                if ($this->Auth->login()) {
                $this->loginProcedures();
                $this->redirect($this->Auth->redirect());                        
                // if the login is not successfull.
                }else{
                    $this->Session->setFlash(__('Username or password is invalid.').'<br/><span class="info">'.__('If you think your account has problem, make contact with contact@hunerakurdi.com.').'</span>','default',array(),'flashError');
                }
            
            
            // if it's not post request
            }else{}
            
        // When the user is logged in.
        }else{
            $this->redirect(array('controller'=>'dashboard','action' => 'index'));
        }
        
        

            
        
        

    }
    
    
    private function loginProcedures(){

        $this->premissionsArray();
        $this->Session->setFlash(
                __('Login successfully,you are now free to add or edit lyrics.'), //Message
                'flash',                   //Element 
                array(
                    'title' => __('Login status'),
                    'position'=>'bottom',
                    'type'=>'primary'
                    )
                );
    }

    public function logout(){

        if ($this->request->is('ajax')){
            $this->logoutAjax();
        }else{
            $this->logoutNormal();
        }        
    }
    
    private function logoutAjax() {

        if ($this->Session->check('Auth.User')){
            $this->Session->delete('Auth.Acl');
            $this->Cookie->delete('rememberMe');
            $this->Session->destroy();
            $this->HybridAuth->logout();
            $this->Session->setFlash(
                    __('You are loggedout now,thank you for using HK-Dashboard.'), //Message
                    'flash',                   //Element 
                    array(
                        'title' => __('Logout status'),
                        'position'=>'bottom',
                        'type'=>'info'
                        )
                    );
            $returnment['error'] = false;
            $returnment['refresh'] = true;
        }else{
            $returnment = false;
        }
        
        echo json_encode($returnment);
        die();
    }
        
    private function logoutNormal() {
        
        if ($this->Session->check('Auth.User')){
            
            $this->Session->delete('Auth.Acl');
            $this->Cookie->delete('rememberMe');
            $this->Session->destroy();
            $this->HybridAuth->logout();

            $this->Session->setFlash(
                    __('You are loggedout now,thank you for using HK-Dashboard.'), //Message
                    'flash',                   //Element 
                    array(
                        'title' => __('Logout status'),
                        'position'=>'bottom',
                        'type'=>'info'
                        )
                    );
            return $this->redirect($this->Auth->logout());
        }else{
            $this->redirect($this->Auth->redirectUrl());
        }  
    }
    

    
        private function settings_($user = null){
                 
            $this->set('title',__("%s's settings",$user['User']['name']));
            $this->set('user',$user);
            
            if ($this->request->is(array('post', 'put'))){
                $this->User->unique = $user['User']['unique'];
                $this->User->id = $user['User']['id'];
                
                $dataArray = [];
                $dataArray ['User']['name'] = $this->HK->replaceSpecial(h($this->request->data['User']['name']));
                $dataArray ['User']['first_name'] = $this->HK->replaceSpecial(h($this->request->data['User']['first_name']));
                $dataArray ['User']['last_name'] = $this->HK->replaceSpecial(h($this->request->data['User']['last_name']));
                $dataArray ['User']['infos'] = $this->HK->replaceSpecial(h($this->request->data['User']['infos']));
                $dataArray ['User']['birthday'] = $this->request->data['User']['birthday'];
                
        
                
                if ($this->User->save($dataArray)){

                        $this->Session->setFlash(
                            __('The settings has been updated for %s.','<strong>'.$user['User']['name'].'</strong>').'<br/>'.__('You have to logout to see the effects.'), //Message
                            'flash',                   //Element 
                            array(
                                'title' => __('Update status'),
                                'position'=>'left',
                                'type'=>'success'
                                )
                            );
                            return $this->redirect(array('controller'=>'users','action' => 'profile',$user['User']['unique']));

                }else {
                        $this->Session->setFlash(__('The settings could not be saved. Please, try again.'),'default',array(),'flashError');
                        
                }
                
                
            }else{
                $this->request->data = $user;
            }
       
        }
        
        
        private function settings_addPhoto($user){
            
            
            if ($this->Session->check('Upload')){
                if (!file_exists($this->Session->read('Upload.file'))){
                    $this->Session->delete('Upload');
                }
            }
            if ($user['User']['name'] != '' || $user['User']['name'] != null){
                $_username = $user['User']['name'];
            }else{
                $_username = $user['User']['username'];
            }
            $this->set('title',__('%s photo',$_username));
                
            if($this->request->is('post')){
                
                $file = '';
                if($this->HK->upload($this->request->form['file'],$this->Session->read('Auth.User.unique'),$file)){
                    
                    $H = $this->HK->getHeight($file);
                    $W = $this->HK->getWidth($file);
                    
                    $fileName = substr($file, -13, 13);
                    $fileDir = substr($file, +0, -13);
                    
                //uplaoded image is least than 200px hight/width
                    if ($H<200 || $W<200){
                        
                        $this->Session->setFlash(__('The photo is too small.').'<br/>'.__('You must upload over 200 pixel photo height and width.'),'default',array(),'flashError');
                        unlink($file);
                //uploaded image is square
                    }else if ($H == $W){
                        
                        $sessArray['Upload.file'] = $file;
                        $sessArray['Upload.thumb'] = '_'.$fileName;
                        $sessArray['Upload.fileName'] = $fileName;
                        $sessArray['Upload.fileDir'] = $fileDir;
                        $sessArray['Upload.fileH'] = $H;
                        $sessArray['Upload.fileW'] = $H;
                        $sessArray['Upload.artistUnique'] = $user['User']['unique'];
                        $sessArray['Upload.artistName'] = $user['User']['username'];
                        
                        $this->Session->write($sessArray);
                        
                        $thumb = $this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb');
                        $this->HK->resizeThumbnailImage($thumb, $file,$H,$H,0,0,200/$H);
                        
                        return $this->redirect(array('controller' => 'users', 'action' => 'settings','photo',$user['User']['unique'],'accept'));

                //uploaded image is not square and greater than 200px width/height
                    }else{
                        
                        
                        $sessArray['Upload.file'] = $file;
                        $sessArray['Upload.thumb'] = '_'.$fileName;
                        $sessArray['Upload.fileName'] = $fileName;
                        $sessArray['Upload.fileDir'] = $fileDir;
                        $sessArray['Upload.fileH'] = $H;
                        $sessArray['Upload.fileW'] = $W;
                        $sessArray['Upload.artistUnique'] = $user['User']['unique'];
                        $sessArray['Upload.artistName'] = $user['User']['username'];
                        
                        $this->Session->write($sessArray);
                        
                       
                    }
                }
                
                if (isset($this->request->data['crop'])){
                    
                    $data = $this->request->data;
                    $file = $this->Session->read('Upload.file');
                    $thumb = $this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb');
                    $thumb_width = 200;
                    
                    
                     if (
                            ($data['x1'] == '' ||
                             $data['y1'] == '' ||
                             $data['x2'] == '' ||
                             $data['y2'] == '' ||
                             $data['w'] == ''  ||
                             $data['h'] == '')
                            
                        ){
                            $this->Session->setFlash(__('You have to select square photo for artist.'),'default',array(),'flashError');
                        }else if (
                                
                                (!($this->Session->check('Upload.fileName'))&&
                                !($this->Session->check('Upload.artistUnique')))
                                ||
                                file_exists($file) == false
                            
                        ){
                            
                            $this->Session->setFlash(__('You have to select a file photo for artist.'),'default',array(),'flashError');
                        }else{
                            
                            // if thumbnail is exists.
                            if (file_exists($thumb)){
                                unlink($thumb);
                                
                            }
                            
                            $scale = $thumb_width/$data['w'];
                            $this->HK->resizeThumbnailImage($thumb, $file,$data['w'],$data['h'], $data['x1'],$data['y1'],$scale);
                        }
                        
                        
                }
                
            }
            
            if ($this->Session->check('Upload.fileName') && $this->Session->check('Upload.artistUnique') && !(file_exists($this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb')))){
                 $this->render('add_photo_crop');
//                      return $this->redirect(array('controller'=>'artists','action' => 'add','photo',$this->Session->read('Upload.artistUnique')));
            }else if(file_exists($this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb'))){
                        $this->render('add_photo_thumb_view');
            }else{
                
                 $this->render('add_photo');
            }
                    
            
        }
        
        
    public function settings($additions = null, $unique = null,$action = null) {
        
        
        if ($this->HK->uniqueCheck($additions)){
            $unique = $additions;
        }
        

        
        if ($unique==null){throw new NotFoundException(__('Unknown user.'));}
        
        $user = $this->User->findByUnique($unique);
        if (empty($user)){throw new NotFoundException(__('Unknown user.'));}
        if (!$this->Acl->check($this->group,'User','update') && $this->Session->read('Auth.User.username')!=$user['User']['username']){throw new NotFoundException(__('Unknown user.'));}
        
        if ($user['User']['name'] != '' || $user['User']['name'] != null){
            $_username = $user['User']['name'];
        }else{
            $_username = $user['User']['username'];
        }
            
        $this->set('user',$user);
        $this->set('unique',$unique);       
            
            
            //check the request type
            $sec = 'general';
            if ($additions == 'photo'){
                $sec = 'photo';
            }
                       
            if ($sec == 'photo'){
            //check upload session.
                if ($this->Session->check('Upload')){
                        $uploadArray = $this->Session->read('Upload');
                        $file = $uploadArray['file'];
                        $thumb = $uploadArray['fileDir'].$uploadArray['thumb'];
                //check if the file exists when session is set
                    if (file_exists($file)){
                    //accept action to photo
                        if($action == 'accept'){
                        // if the image field in DB is empty.
                            if ($user['User']['image'] == null || $user['User']['image'] == '' || $user['User']['image'] == 'endam-nenas.jpg'){
                                
                                $_ext = $fileName = substr($thumb, -4, 4);
                                $_fileName = $this->HK->setFileName($user['User']['unique'].$_ext);
                                
                                $this->User->id = $user['User']['id'];
                                $this->User->saveField('image', $_fileName);
                                
                            }else{
                                $_fileName = $user['User']['image'];
                            }
                            
                            $_finalDir = WWW_ROOT.'wene'.DS.'endam'.DS;
                            $_finalFile = $_finalDir . $_fileName;
                            
                            if (copy($thumb,$_finalFile)){
                                
//                                if (!$this->HK->createThumbnails($_fileName,$_finalDir)){
//                                    die('#UC_679');
//                                }
                                
                                $this->Session->delete('Upload');
                                unlink($file);
                                unlink($thumb);

                            }else{
                                $this->Session->setFlash(__("Couldn't copy the photo."),'default',array(),'flashError');
                            }
                            
                            $this->Session->setFlash(
                                    __('The photo for user %s has been saved successfully.', '<em>'.$_username.'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Save status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'success'
                                        )
                                    );
                            return $this->redirect(array('controller' => 'users' , 'action' => 'settings',$unique));

                        }
                        
                    //delete action to photo
                        else if ($action == 'delete'){
                            
                            $this->User->id = $user['User']['id'];
                            $this->User->saveField('image', 'endam-nenas.jpg');
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            $this->Session->setFlash(
                                    __('The photo for user %s has been rest for default.', '<em>'.$_username.'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Delete status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'warning'
                                        )
                                    );

                            return $this->redirect(array('controller' => 'users' , 'action' => 'settings',$unique));
                            
                        //recrop action to photo
                        }else if($action == 'recrop'){

                            if (file_exists($thumb)){unlink($thumb);}
                            
                            return $this->redirect(array('controller' => 'users' , 'action' => 'settings','photo',$unique));

                          
                        // cancel action to photo
                        }else if($action == 'cancel'){
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            return $this->redirect(array('controller' => 'users' , 'action' => 'settings','photo',$unique));
                        }
                    }
                    
                }
                
                // delete action without uploading or creating or croping photos
                if ($action == 'delete'){
                    $this->User->id = $user['User']['id'];
                    $this->User->saveField('image', 'endam-nenas.jpg');
                    return $this->redirect(array('controller' => 'users' , 'action' => 'settings','photo',$unique));
                }
                
                $this->settings_addPhoto($user);
           
            
            }else{
                $this->settings_($user);
            }
	}
    
    public function profile($unique=null){
        
    if ($this->HK->uniqueCheck($unique)){
            
        $user=$this->User->findByUnique($unique
                                        );
            if (!empty($user)){

            $userArtistsLatest =    $this->requestAction(array('controller'=>'artists','action'=>'userArtists' ,$user['User']['unique'],'latest'));
            $userAlbumsLatest =     $this->requestAction(array('controller'=>'albums' ,'action'=>'userAlbums'  ,$user['User']['unique'],'latest'));
            $userLyricsLatest =     $this->requestAction(array('controller'=>'lyrics' ,'action'=>'userLyrics'  ,$user['User']['unique'],'latest'));
            $userLyricsPopular =    $this->requestAction(array('controller'=>'lyrics' ,'action'=>'userLyrics'  ,$user['User']['unique'],'popular'));
            
                $this->set('title',$user['User']['name']);
                
                $setArray['user']=$user;
                
                $setArray['userArtistsLatest']  = $userArtistsLatest;
                $setArray['userAlbumsLatest']   = $userAlbumsLatest;
                $setArray['userLyricsLatest']   = $userLyricsLatest;
                $setArray['userLyricsPopular']  = $userLyricsPopular;
                
                $this->set($setArray);
                
            }else{
                throw new NotFoundException(__('Unknown user.'));
            }
        }else{
            throw new NotFoundException(__('Unknown user.'));
        }	
    }

    
        
    public function property($section=null,$unique=null){
        $fieldsArray = array('User.id','User.unique','User.name','User.artist_counter','User.album_counter','User.lyric_counter',);
        
        if ($unique==null){
            if ($section!=null){
                
                $user=$this->User->findByUnique($section,$fieldsArray);
                if(empty($user)){throw new NotFoundException(__('Unknown user.'));}
                $this->set('title',__('%s\'s Properties',$user['User']['name']));
                $this->set('user',$user);
            }else{
                throw new NotFoundException(__('Unknown user.'));

            }
        }else{
            $user=$this->User->findByUnique($unique,$fieldsArray);
            if(empty($user)){throw new NotFoundException(__('Unknown user.'));}
            $this->set('user',$user);
        
        $this->set('title',__('%s\'s Properties',$user['User']['name']));
        $this->set('section',$section);
        
        if ($section=='artists'){
            
//////////// Artist section starts.
                $this->loadModel('Artist');
                $this->Paginator->settings['limit']=10;
                $this->Paginator->settings['order']='created DESC';
                $this->Artist->recursive = 0;
                $options=array(
//                    'Artist.available' => 'yes',
                    'Artist.user_id' => $user['User']['id']
                );  

                
                $this->set('artists', $this->Paginator->paginate('Artist',$options));
                $this->render('property_artist');

////////// Artist section ends
                
        }
        else if ($section=='albums'){
            
            
//////////// Album section starts.
            
                $this->loadModel('Album');
                $this->Paginator->settings['limit']=10;
                $this->Paginator->settings['order']='Album.created DESC';
                $this->Album->recursive = 0;
                $options=array(
//                    'Album.available' => 'yes',
                    'Album.user_id' => $user['User']['id']
                );  

                
                $this->set('albums', $this->Paginator->paginate('Album',$options));
                $this->render('property_album');

////////// Album section ends
                
        }
        else if ($section=='lyrics'){
            
            
            
//////////// Lyric section starts.
            
                $this->loadModel('Lyric');
                $this->Paginator->settings['limit']=10;
                $this->Paginator->settings['order']='Lyric.created DESC';
                $this->Lyric->recursive = 0;
                $options=array(
//                    'Lyric.available' => 'yes',
                    'Lyric.user_id' => $user['User']['id']
                );  

                
                $this->set('lyrics', $this->Paginator->paginate('Lyric',$options));
                $this->render('property_lyric');

////////// Lyric section ends
                
                
        }
        
        else{throw new NotFoundException(__('Unknown section.'));}
    }}
    
    
    public function signup(){$this->set('title',__('Signup'));
    
    if ($this->Session->check('Auth.User')){
        $this->redirect($this->Auth->redirectUrl());
        exit();
    }
        if ($this->request->is('post')) {
            $this->User->create();
            
            if (isset($this->request->data['User']['username'])){$this->request->data['User']['username'] = strtolower($this->request->data['User']['username']);}
                        $dataArray['username']=$this->request->data['User']['username'];
                        $dataArray['name']=$this->HK->capitalizeLetter($this->request->data['User']['username']);
                        $dataArray['group_id']=5;
                        $dataArray['image']='endam-nenas.jpg';
                        $dataArray['password']=$this->request->data['User']['password'];
                        $dataArray['email']=$this->request->data['User']['email'];
                        $dataArray['available']='yes';
                        
            
            if ($this->User->save($dataArray)) {
                
                    $this->Session->setFlash(
                                __('New user has been added successfully,please add further informations about you.'), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('The user has been saved'),
                                    'position'=>'bottom',
                                    'type'=>'success'
                                    )
                                );
                    
                    $this->login();
                    return $this->redirect(array('controller'=>'Users','action' => 'completesignup'));
            }
        
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array(),'flashError');
        }
    }
    
    
    
    
    public function add() {
        
        if(!$this->Acl->check($this->group,'User','create')){throw new NotFoundException(__('Not found'));}
		if ($this->request->is('post')) {
			$this->User->create();
                        $dataArray['username']=$this->request->data['User']['username'];
                        $dataArray['name']=$this->HK->capitalizeLetter($this->request->data['User']['username']);
                        $dataArray['group_id']=$this->request->data['User']['group_id'];
                        $dataArray['password']=$this->request->data['User']['password'];
                        $dataArray['email']=$this->request->data['User']['email'];
                        $dataArray['name']=$this->request->data['User']['name'];
                        $dataArray['available']=$this->request->data['User']['available'];
			if ($this->User->save($dataArray)) {
				$this->Session->setFlash(__('The user has been saved.'),'default',array(),'flashError');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array(),'flashError');
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set('title',__('Add users'));
                $this->set(compact('groups'));
		
	}
        
        
        
        
    public function delete($id = null) {
        
        throw new NotFoundException(__('Invalid user'));
//        if(!$this->Acl->check($this->group,'User','delete')){throw new NotFoundException(__('Not found'));}
//        
//            $this->User->id = $id;
//            if (!$this->User->exists()) {
//                    throw new NotFoundException(__('Invalid user'));
//            }
//            $this->request->allowMethod('post', 'delete');
//            if ($this->User->delete()) {
//                    $this->Session->setFlash(__('The user has been deleted.'),'default',array(),'flashError');
//            } else {
//                    $this->Session->setFlash(__('The user could not be deleted. Please, try again.'),'default',array(),'flashError');
//            }
//            return $this->redirect(array('action' => 'index'));
    }    
    
    
    
    public function recovery(){
        return true;    
    }
    public function edit($id = null) {
        throw new NotFoundException(__('Invalid user'));
//        if(!$this->Acl->check($this->group,'User','update')){throw new NotFoundException(__('Not found'));}
//        if (!$this->User->exists($id)) {
//                throw new NotFoundException(__('Invalid user'));
//        }
//            
//        if ($this->request->is(array('post', 'put'))) {
//                if ($this->User->save($this->request->data)) {
//                        $this->Session->setFlash(__('The user has been saved.'),'default',array(),'flashError');
//                        return $this->redirect(array('action' => 'index'));
//                } else {
//                        $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default',array(),'flashError');
//                }
//        } else {
//                $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
//                $this->request->data = $this->User->find('first', $options);
//        }
//        $groups = $this->User->Group->find('list');
//        $this->set('title',__('Add users'));
//        $this->set(compact('groups'));
    }
    
   
    
    
}
