<?php
App::uses('AppController', 'Controller');
App::uses('config','config' );
App::uses('HKComponent', 'Component');

/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ArtistsController extends AppController {

        
    
    private $user;
    private $group;
    
    
    function beforeFilter() {
        parent::beforeFilter();
        
        $allowedArray=array('index','view','userArtists',);
        $this->Auth->allow($allowedArray);
            
        $user=$this->user=$this->Auth->user();
        $group=$this->Artist->User->Group;
        $group->id=$user['Group']['id'];
        $this->group=$group;
        
    }
    
    

    
    public function index($uri=null) {

        // check passed value to index function. 
       
        // empty argument (Wlecome page)
        if ($uri==null){
            $this->indexWelcome();
            
        // valued argument( letter or artist [unique, name] )
        }else{
            
            
            if($this->HK->uniqueCheck($uri)){
                
                // Artist unique ID
                $this->indexArtistUnique($uri);

            }else{
                
                
                // Pure text is returned.
                
                // unique returned
                if($this->HK->letterCheck($uri) == true){
                    $this->indexLetter($uri);
                
                // artist name returned
                }else{
                    
                    $this->indexArtist($uri);
                }
                
                

            }

            
            
        }
    }
        
        private function indexWelcome() {
            $this->set('title',__('Welcome to Hunera Kurdi'));    
            $this->set('statics',$this->HK->Statics());
            $this->render("Welcome");
	}
        
    private function indexLetter($_artist){


        if ($this->HK->letterCheck($_artist)){
            $_artist=$this->HK->capitalizeLetter($_artist);
            $this->Artist->recursive=0;
            $artists=$this->Artist->find('all',
                    array(
                        'conditions'=>array(
                            'Artist.deleted' =>'no',
                            'Artist.available'=>'yes',
                            'Artist.name like'=>$_artist.'%'

                            )
                        ));

            $this->set('title',__($_artist));
            $this->set('letter',$_artist);

            if ($artists){$this->set('artists',$artists);
                $this->render("artist_list");
            }else{$this->render("artist_list_empty");
            }

        }else{
                throw new NotFoundException('Unsigend letter.');
        }

    }
        
        
    private function indexArtistUnique($letter){

        $this->Artist->recursive=2;

            $artist=$this->Artist->findByUnique($letter);

            if ($artist == null || empty($artist)){throw new NotFoundException(__('Artist not found!'));}
            $this->set('title', $artist['Artist']['name']);
            $this->set('letter', $this->HK->letter($artist['Artist']['name']));
            $this->set('artist',$artist);
            
    }
    
    
    private function indexArtist($_artist){
        
        
        $redirectUrl = FULL_BASE_URL.'/hunermend/';
        if (!($_artist = $this->HK->uriDecoder($_artist))){$this->redirect($redirectUrl);}

        
            $this->Artist->recursive=2;


            $artist = $this->Artist->find('all',array(
                'conditions' => array('LOWER(Artist.name)' => $_artist),
            ));
            
            
            if ($artist == null || empty($artist)){throw new NotFoundException(__('Artist not found!'));}
            
            // 1 - if $artist is one item
            if(sizeof($artist) == 1){
                $artist = $artist[0];
            
            // 0 - if $artist array is empty
            }elseif(sizeof($artist) == 0){
                
                $this->redirect($redirectUrl);
                
            // +1 - if $artist array is more than one.
            }else{  
                // just select the first item   d(-_-)b
                 $artist = $artist[0];
            }
            
            $this->set('title', $artist['Artist']['name']);
            $this->set('letter', $this->HK->letter($artist['Artist']['name']));
            $this->set('artist',$artist);
            
         
         
    }

    /**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {


        if (!$this->Artist->exists($id)) {throw new NotFoundException(__('Invalid artist'));}
            $options = array('conditions' => array('Artist.' . $this->Artist->primaryKey => $id));
            $this->set('artist', $this->Artist->find('first', $options));
    }
    
    



/**
 * add method
 *
 * @return void
 */
    
        public function userArtists($unique=null,$type=null){
            if ($unique==null){return null;}            
            $user=$this->Artist->User->findByUnique($unique);
            if ((empty($user['User']))){return null;}

            if ($type!=null){
                if ($type=='latest'){
                    $this->Artist->recursive=0;
                    $userArtists=$this->Artist->find('all',array(
                                                                'conditions'=>array('Artist.available'=>'yes','Artist.user_id'=>$user['User']['id']),
                                                                'fields'=>array('Artist.unique','Artist.name','Artist.album_counter','Artist.lyric_counter','Artist.created',),
                                                                'order'=>array('Artist.created DESC'),
                                                                'limit'=>10,
                                                            )
                                                    );
                    return $userArtists;
                }else{
                    
                }
            }else{
                
                $userArtists=$this->Artist->find('all',array(
                                                            'conditions'=>array('Artist.available'=>'yes','Artist.user_id'=>$user['User']['id']),
                                                            'order'=>array('Artist.name ASC'),
                                                        )
                                                );
                return $userArtists;
            }
            
 
        }
    
        public function add($additions = null, $unique = null,$action = null) {
            
            if(!$this->Acl->check($this->group,'Artist','create')){throw new NotFoundException(__('Not found'));}
            
            //check the request type
            $sec = 'general';
            if ($additions == 'photo'){
                if ($unique != null){
                    $artist = $this->Artist->findByUnique($unique);
                    $this->set('letter', $this->HK->letter($artist['Artist']['name']));
                    $this->set('unique',$unique);
                    $this->set('artist',$artist);
                    if (!empty($artist) && $artist != null){
                       $sec = 'photo';
                    }
                }
            }
            
            
            if ($sec == 'photo'){

                if (!$this->Acl->check($this->group,'Artist','update') &&!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));} 
                
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
                            if ($artist['Artist']['image'] == null || $artist['Artist']['image'] == '' || $artist['Artist']['image'] == 'hunermend-nenas.jpg'){
                                
                                $_ext = $fileName = substr($thumb, -4, 4);
                                $_fileName = $this->HK->setFileName($artist['Artist']['name'].$_ext);
                                
                                $this->Artist->id = $artist['Artist']['id'];
                                $this->Artist->saveField('image', $_fileName);
                                
                            }else{
                                $_fileName = $artist['Artist']['image'];
                            }
                            
                            $_finalDir = WWW_ROOT.'wene'.DS.'hunermend'.DS;
                            $_finalFile = $_finalDir . $_fileName;
                            
                            if (copy($thumb,$_finalFile)){
                                
//                                if (!$this->HK->createThumbnails($_fileName,$_finalDir)){
//                                    die('#AC_219');
//                                }
                                
                                $this->Session->delete('Upload');
                                unlink($file);
                                unlink($thumb);

                            }else{
                                $this->Session->setFlash(__("Couldn't copy the photo."),'default',array(),'flashError');
                            }
                            
                            $this->Session->setFlash(
                                    __('The photo for artist %s has been saved successfully.', '<em>'.$artist['Artist']['name'].'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Save status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'success'
                                        )
                                    );
                            return $this->redirect(array('controller' => 'artists' , 'action' => 'index',$unique));

                        }
                        
                    //delete action to photo
                        else if ($action == 'delete'){
                            
                            $this->Artist->id = $artist['Artist']['id'];
                            $this->Artist->saveField('image', 'hunermend-nenas.jpg');
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            $this->Session->setFlash(
                                    __('The photo for artist %s has been rest for default.', '<em>'.$artist['Artist']['name'].'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Delete status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'warning'
                                        )
                                    );

                            return $this->redirect(array('controller' => 'artists', 'action' => 'index',$unique));
                            
                        //recrop action to photo
                        }else if($action == 'recrop'){

                            if (file_exists($thumb)){unlink($thumb);}
                            return $this->redirect(array('controller' => 'artists', 'action' => 'add','photo',$unique));

                          
                        // cancel action to photo
                        }else if($action == 'cancel'){
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            return $this->redirect(array('controller' => 'artists', 'action' => 'add','photo',$unique));
                        }
                    }
                    
                }
                
                // delete action without uploading or creating or croping photos
                if ($action == 'delete'){
                    $this->Artist->id = $artist['Artist']['id'];
                    $this->Artist->saveField('image', 'hunermend-nenas.jpg');
                    return $this->redirect(array('controller' => 'artists', 'action' => 'index',$unique));
                }
                
                $this->addphoto($artist);
           
            // add artist name
            }else{
                $this->addNew();
            }
            
            
                $this->set('title',__('Add Artist'));
                
	}
        
        
        private function addPhoto($artist){
            
            
            if ($this->Session->check('Upload')){
                if (!file_exists($this->Session->read('Upload.file'))){
                    $this->Session->delete('Upload');
                }
            }
            $this->set('title',__('%s photo',$artist['Artist']['name']));
                
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
                        $sessArray['Upload.artistUnique'] = $artist['Artist']['unique'];
                        $sessArray['Upload.artistName'] = $artist['Artist']['name'];
                        
                        $this->Session->write($sessArray);
                        
                        $thumb = $this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb');
                        $this->HK->resizeThumbnailImage($thumb, $file,$H,$H,0,0,200/$H);
                        
                        return $this->redirect(array('controller' => 'artists', 'action' => 'add','photo',$artist['Artist']['unique'],'accept'));

                //uploaded image is not square and greater than 200px width/height
                    }else{
                        
                        
                        $sessArray['Upload.file'] = $file;
                        $sessArray['Upload.thumb'] = '_'.$fileName;
                        $sessArray['Upload.fileName'] = $fileName;
                        $sessArray['Upload.fileDir'] = $fileDir;
                        $sessArray['Upload.fileH'] = $H;
                        $sessArray['Upload.fileW'] = $W;
                        $sessArray['Upload.artistUnique'] = $artist['Artist']['unique'];
                        $sessArray['Upload.artistName'] = $artist['Artist']['name'];
                        
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
        
        private function addCreateThumbnail($image){
            
           
            
        }
        
        private function addNew(){
            
           $this->set('artistExists',false);
                
            if ($this->request->is('post')) {
                $this->request->data['Artist']['name']=$this->HK->replaceSpecial($this->request->data['Artist']['name']);
                $this->Artist->create();

                if ($this->Acl->check($this->group,'Artist','update')){$available='yes';}else{$available='no';}

                $dataArray=array();
                $dataArray['Artist']['name']=h($this->request->data['Artist']['name']);
                $dataArray['Artist']['available']=$available;
                $dataArray['Artist']['image']='hunermend-nenas.jpg';
                $dataArray['Artist']['user_id']=$this->Auth->user('id');
                
                            if ($this->Artist->save($dataArray)) {

                                $this->Session->setFlash(
                                    __('The artist %s has been saved.', '<em>'.$dataArray['Artist']['name'].'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Save status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>7777,
                                        'type'=>'success'
                                        )
                                    );

                                return $this->redirect(array('controller'=>'artists','action' => 'add','photo',$this->Artist->unique));
                                
                            }else{
                                
                                if ($this->Artist->artistExist == true){
                                    $this->set('artistExists',true);
                                    $this->set('artistExist',$this->Artist->findByName($this->Artist->sanitize($this->data['Artist']['name'], "-'")));
                                }
                                $this->Session->setFlash(__('The artist could not be saved. Please, try again.'),'default',array(),'flashError');
                            }
                    }
            
        }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($unique = null) {
        
        $this->set('artistExists',false);
        
        if ($unique==null){throw new NotFoundException(__('Empty artist!'));}
        if(!$this->Acl->check($this->group,'Artist','update')&&!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));}
        if (!$artist=$this->Artist->findByUnique($unique)) {throw new NotFoundException(__('Invalid artist'));}
        
        $this->Artist->recursive=0;    
        $this->Artist->unique=false;
            
        
            $this->Artist->id=$id=$artist['Artist']['id'];
            
            $this->set('artist',$artist);
            $this->set('title',__('Edit %s',$artist['Artist']['name']));
            $this->set('letter', $this->HK->letter($artist['Artist']['name']));
            if ($this->request->is(array('post','put'))){
                 $this->request->data['Artist']['name']=$this->HK->replaceSpecial($this->request->data['Artist']['name']);
                $dataArray['Artist']['name']=h($this->request->data['Artist']['name']);
                if (isset($this->request->data['Artist']['image'])){$dataArray['Artist']['image']=$this->request->data['Artist']['image'];}
                
                
                if ($this->Artist->save($dataArray)) {
                    
                    // notificarion 
                    if (!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){
                     
                        $from = $this->Auth->user('id');
                        $to = $artist['Artist']['user_id'];
                        $noteId = 11;
                        $marks = array('artistUnique' => $artist['Artist']['unique'],'artistName' => $artist['Artist']['name']);
                        $this->HK->notificate($from,$to,$noteId,$marks);
                    
                        
                    }
                        // flash message 
                        $this->Session->setFlash(
                                __('The artist %s has been updated.','<em>'.$dataArray['Artist']['name'].'</em>'), //Message
                                'flash',                   //Element 
                                    
                                array(
                                    'title' => __('Update status'),
                                    'position'=>'top',
                                    'velocity'=>200,
                                    'delay'=>7777,
                                    'type'=>'success'
                                    )
                                );
                        // redirect after saving
                    return $this->redirect(array('controller'=>'artists','action' => 'index',$this->Artist->letter));
                    
                }else{
                    if ($this->Artist->artistExist == true){
                        $this->set('artistExists',true);
                        $this->set('artistExist',$this->Artist->findByName($this->Artist->sanitize($this->data['Artist']['name'], "-'")));
                    }
                    
                    $this->Session->setFlash(__('The artist could not be saved. Please, try again.'),'default',array(),'flashError');
                        
                }
            }else{
                $options = array('conditions' => array('Artist.' . $this->Artist->primaryKey => $id));
                $this->request->data = $this->Artist->find('first', $options);
            }
      
    }

    
	public function delete($id = null) {
            
        if(!$this->Acl->check($this->group,'Artist','delete')&&!$this->Artist->isOwnedBy($id,$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));}
            
            $this->Artist->id = $id;
            $artist = $this->Artist->findById($id);
            if (empty($artist)){throw new NotFoundException(__('Invalid artist'));}
            
		$this->request->allowMethod('post', 'delete');
		if ($this->Artist->del()) {
                                            
                    // notificarion 
                    if (!$this->Artist->isOwnedBy($artist['Artist']['id'],$this->Auth->user('id'))){

                        $from = $this->Auth->user('id');
                        $to = $artist['Artist']['user_id'];
                        $noteId = 13;
                        $marks = array('artistUnique' => $artist['Artist']['unique'],'artistName' => $artist['Artist']['name']);
                        $this->HK->notificate($from,$to,$noteId,$marks);

                    }

                    // flash message         
                    $this->Session->setFlash(
                                __('The artist %s has been deleted.',$artist['Artist']['name']), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('Delete status'),
                                    'position'=>'top',
                                    'velocity'=>200,
                                    'delay'=>7777,
                                    'type'=>'warning'
                                    )
                                );
		} else {
                    $this->Session->setFlash(__('The artist could not be deleted. Please, try again.'),'default',array(),'flashError');
		}
		return $this->redirect(array('controller'=>'artists','action' => 'index',$this->HK->letter($artist['Artist']['name'])));
	}
}
