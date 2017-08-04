<?php

class AlbumsController extends AppController {

 
    private $user;
    private $group;
    

    public function beforeFilter() {
        
        
        parent::beforeFilter();

        $this->Auth->allow('index','view','userAlbums');
        
        $user=$this->user=$this->Auth->user();
        $group=$this->Album->User->Group;
        $group->id=$user['Group']['id'];
        $this->group=$group;
        
 
    }


    public function index($uriArtist=null,$uriAlbum=null) {
        
        
        $albumOptionArray = array(
            'fields' =>array(
                'Artist.unique',
                'Artist.name',
                'Album.id',
                'Album.unique',
                'Album.title',
                'Album.year',
                'Album.image',
                'Album.year',
                'Album.lyric_counter',
                'Album.available',
                'Album.deleted',

            ),
            
        );
        
        if ($this->HK->uniqueCheck($uriArtist)){
            $this->Album->recursive = 1;
            $albumOptionArray['conditions'] = array( 'Album.unique' => $uriArtist);
            $album = $this->Album->find('first',$albumOptionArray);
        }else{
            
            $redirectArtist = FULL_BASE_URL.'/hunermend/'.$uriArtist.'/';
            
            // check if title is set
            if ($uriAlbum == null || $uriAlbum == ''){    
                $this->redirect($redirectArtist);
            }
            
            // set decode the title to pure text
            if (!($_title = $this->HK->uriDecoder($uriAlbum,'album')) || !($_year = $this->HK->uriDecoder($uriAlbum,'year'))){
                $this->redirect($redirectArtist);
            }
            
            // select the title from database.
            $this->Album->recursive = 1;
            $albumOptionArray['conditions'] = array('LOWER(Album.title)' => $_title);
            
            $_albums = $this->Album->find('all',$albumOptionArray);
            
            
            // 1 - check if $_lyric array is one single item
            if(sizeof($_albums) == 1){
                $album = $_albums[0];
            
            // 0 - if $_lyrcs array is empty
            }elseif(sizeof($_albums) == 0){
                $this->redirect($redirectArtist);
            
                
            // +1 - if $_lyric array is more than one.
            }else{                
                    if (!($_album = $this->HK->uriDecoder($uriAlbum,'album'))){$this->redirect($redirectArtist);}
                    if (!($_year = $this->HK->uriDecoder($uriAlbum,'year'))){$this->redirect($redirectArtist);}
                    if (!($_artist = $this->HK->uriDecoder($uriArtist))){$this->redirect($redirectArtist);}
                    
                foreach ($_albums as $key => $value){
                    
                    // Select the exact array for $lyric.
                    if (
                            (mb_strtolower ($value['Artist']['name']) == $_artist) &&
                            (mb_strtolower ($value['Album']['title']) == $_album) &&
                            (mb_strtolower ($value['Album']['year']) == $_year) &&
                            (           $value['Album']['deleted']) == 'no'
                            
                    ){
                        
                        $album = $value;
                        break;
                        
                    }else{
                        $this->redirect($redirectArtist);
                    }
                }
                
            }
        }
        
            
                if (@$album==null || empty($album)){throw new NotFoundException(__('Album not found.'));}
                    
                    
                    $this->set('title',$album['Artist']['name']."-".$album['Album']['title']);
                    $this->set('letter',  mb_substr($album['Artist']['name'],0,1,'utf-8'));
                    $this->set('album',$album);
                    
    }

    public function userAlbums($unique=null,$type=null){
            
            if ($unique==null){return null;}            
            $user=$this->Album->User->findByUnique($unique);
            if ((empty($user['User']))){return null;}

            if ($type!=null){
                if ($type=='latest'){
                    
                    $options = array(
                                    'conditions'=>array('Album.available'=>'yes','Album.user_id'=>$user['User']['id']),
                                    'order'=>array('Album.created DESC'),
                                    'limit'=>10,
                                );
                }else{
                    
                
                    
                }
                
            }else{
                
                $options = array(
                                'conditions'=>array('Album.available'=>'yes','Album.user_id'=>$user['User']['id']),
                                'order'=>array('Album.title ASC'),
                            );
            }
            
            $options['fields']=array(
                                    'Album.unique',
                                    'Album.title',
                                    'Album.year',
                                    'Album.lyric_counter',
                                    'Album.created',
                                    'Artist.unique',
                                    'Artist.name',
                                );
            $userAlbum=$this->Album->find('all',$options);
            return $userAlbum;
    }
        



         public function add($additions = null, $unique = null,$action = null) {
            
            if(!$this->Acl->check($this->group,'Album','create')){throw new NotFoundException(__('Not found'));}
            
            //check the request type
            $sec = 'general';
            if ($additions == 'photo'){
                if ($unique != null){
                    $album = $this->Album->findByUnique($unique);
                    if (empty($album) || $album == null){throw new NotFoundException(__('Not found'));}
                    $this->set('album',$album);
                    $this->set('unique',$unique);
                    $this->set('letter',$this->HK->letter($album['Artist']['name']));
                    if (!empty($album) && $album != null){
                       $sec = 'photo';
                    }
                }
            }
            
            if ($this->HK->uniqueCheck($additions)){
                $artistUnique = $additions;
            }else{
                $artistUnique = '';
            }
            
            
            if ($sec == 'photo'){

                if (!$this->Acl->check($this->group,'Album','update') &&!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));} 
               
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
                            if ($album['Album']['image'] == null || $album['Album']['image'] == '' || $album['Album']['image'] == 'berhem-nenas.jpg'){
                               
                                $_ext = $fileName = substr($thumb, -4, 4);
                                $_fileName = $this->HK->setFileName($album['Artist']['name'].'_'.$album['Album']['title'].$_ext);
                                 
                                $this->Album->id = $album['Album']['id'];
                                $this->Album->saveField('image', $_fileName);
                                
                            }else{
                                $_fileName = $album['Album']['image'];
                            }
                            
                            $_finalDir = WWW_ROOT.'wene'.DS.'berhem'.DS;
                            $_finalFile = $_finalDir . $_fileName;
                            
                            if (copy($thumb,$_finalFile)){
                                
//                                if (!$this->HK->createThumbnails($_fileName,$_finalDir)){
//                                    die('#AC_149');
//                                }
                                
                                $this->Session->delete('Upload');
                                unlink($file);
                                unlink($thumb);

                            }else{
                                $this->Session->setFlash(__("Couldn't copy the photo."),'default',array(),'flashError');
                            }
                            
                            $this->Session->setFlash(
                                    __('The photo for album %s has been saved successfully.', '<em>'.$album['Album']['title'].'('.$album['Album']['year'].')'.' - '.$album['Artist']['name'].'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Save status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'success'
                                        )
                                    );
                            return $this->redirect(array('controller' => 'albums' , 'action' => 'index',$album['Album']['unique']));

                        }
                        
                    //delete action to photo
                        else if ($action == 'delete'){
                            
                            $this->Album->id = $album['Album']['id'];
                            $this->Album->saveField('image', 'berhem-nenas.jpg');
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            $this->Session->setFlash(
                                    __('The photo for album %s has been rest for default.', '<em>'.$album['Album']['title'].'('.$album['Album']['year'].')'.' - '.$album['Artist']['name'].'</em>'), //Message
                                    'flash', 
                                    array(
                                        'title' => __('Delete status'),
                                        'position'=>'top',
                                        'velocity'=>200,
                                        'delay'=>6666,
                                        'type'=>'warning'
                                        )
                                    );

                            return $this->redirect(array('controller' => 'albums', 'action' => 'index',$album['Album']['unique']));
                            
                        //recrop action to photo
                        }else if($action == 'recrop'){

                            if (file_exists($thumb)){unlink($thumb);}
                            return $this->redirect(array('controller' => 'albums', 'action' => 'add','photo',$album['Album']['unique']));

                          
                        // cancel action to photo
                        }else if($action == 'cancel'){
                            
                            $this->Session->delete('Upload');
                            unlink($file);
                            if (file_exists($thumb)){unlink($thumb);}
                            
                            return $this->redirect(array('controller' => 'albums', 'action' => 'add','photo',$album['Album']['unique']));
                        }
                    }
                    
                }
                
                // delete action without uploading or creating or croping photos
                if ($action == 'delete'){
                    $this->Album->id = $album['Album']['id'];
                    $this->Album->saveField('image', 'berhem-nenas.jpg');
                    return $this->redirect(array('controller' => 'albums', 'action' => 'index',$album['Album']['unique']));
                }
                
                $this->addphoto($album);
           
            // add new album
            }else{
                
                $this->addNew($artistUnique);
            }
            
            
                $this->set('title',__('Add Album'));
                
	}
        
	private function addNew($artistUnique = null) {
            
            if(!$this->Acl->check($this->group,'Album','create')){throw new NotFoundException(__('Not found'));}
            
            if ($artistUnique!=null){
                $this->Album->Artist->recursive = 0;
                $artist = $this->Album->Artist->findByUnique($artistUnique);
                if ($artist==null || empty($artist)){throw new NotFoundException(__('Artist not found'));}
                $this->Album->artistId=$artist['Artist']['id'];
                $this->Album->artistUnique=$artist['Artist']['unique'];
            }
            
            if ($this->request->is('post')) {
                
                if ($this->Acl->check($this->group,'Album','update')){$available='yes';}else{$available='no';}

                $this->request->data['Album']['title']=$this->HK->replaceSpecial($this->request->data['Album']['title']);
                
                
                
                $this->Album->create();
                        
                        $dataArray=array();
                        if (isset($artist)){
                            $dataArray['Album']['artist_id']=$artist['Artist']['id'];
                        }else{
                            $this->Album->Artist->recursive = 0;
                            $artist = $this->Album->Artist->findById($this->request->data['Album']['artist_id']);
                            if ($artist==null || empty($artist)){throw new NotFoundException(__('Artist not found'));}
                            $dataArray['Album']['artist_id'] = $this->Album->artistId = $artist['Artist']['id'];
                            $this->Album->artistUnique = $artist['Artist']['unique'];
                        }
                        
                        $dataArray['Album']['title']=h($this->request->data['Album']['title']);
                        if (!empty($this->request->data['Album']['year'])){
                            $dataArray['Album']['year'] = $this->request->data['Album']['year']; 
                        }
                        $dataArray['Album']['image']='berhem-nenas.jpg'; 
                        $dataArray['Album']['available']=$available;
                        $dataArray['Album']['user_id']=$this->Auth->user('id');

			if ($this->Album->save($dataArray)) {
                            
                            
                            if (isset($dataArray['Album']['year'])){
                                $albumDetails = ' ('.$dataArray['Album']['year'].')';
                            }else{
                                $albumDetails = ' ';
                            }
                            
                            
                            $this->Session->setFlash(
                                    
                                   
                                __('The album %s has been saved to %s.','<em>'.$dataArray['Album']['title'].$albumDetails.'</em>','<em>'.$artist['Artist']['name'].'</em>'), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('Save status'),
                                    'position'=>'top',
                                    'velocity'=>200,
                                    'delay'=>7777,
                                    'type'=>'success'
                                    )
                                );
                        return $this->redirect(array('controller'=>'albums','action' => 'add','photo',$this->Album->unique));
                                
			} else {$this->Session->setFlash(__('The album could not be saved. Please, try again.'),'default',array(),'flashError');
			}
		}
                
                
                if ($artistUnique){
                    
                    
                    $this->Album->artistId=$artist['Artist']['id'];
                    $this->set('letter', $this->HK->letter($artist['Artist']['name']));
                    $this->set('title',$artist['Artist']['name']."-".__('Add Album'));
                    $this->set('artist',$artist);
                    $this->render('add_artist');
                    
                    
                }else{
                    $artists = $this->Album->Artist->find('list',
                            array(
                                'conditions'=>array('available'=>'yes'),
                                'order'=>array('name ASC')
                                )
                            );
                    $this->set(compact('artists'));
                    $this->set('title',__('Add Album'));
            }   
        
    }
    
    
     private function addPhoto($album){
            
            
            if ($this->Session->check('Upload')){
                if (!file_exists($this->Session->read('Upload.file'))){
                    $this->Session->delete('Upload');
                }
            }
            $this->set('title',__('%s photo',$album['Album']['title'].'-'.$album['Artist']['name']));
                
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
                        $sessArray['Upload.artistUnique'] = $album['Artist']['unique'];
                        $sessArray['Upload.artistName'] = $album['Artist']['name'];
                        
                        $this->Session->write($sessArray);
                        
                        $thumb = $this->Session->read('Upload.fileDir').$this->Session->read('Upload.thumb');
                        $this->HK->resizeThumbnailImage($thumb, $file,$H,$H,0,0,200/$H);
                        
                        return $this->redirect(array('controller' => 'albums', 'action' => 'add','photo',$album['Album']['unique'],'accept'));

                //uploaded image is not square and greater than 200px width/height
                    }else{
                        
                        
                        $sessArray['Upload.file'] = $file;
                        $sessArray['Upload.thumb'] = '_'.$fileName;
                        $sessArray['Upload.fileName'] = $fileName;
                        $sessArray['Upload.fileDir'] = $fileDir;
                        $sessArray['Upload.fileH'] = $H;
                        $sessArray['Upload.fileW'] = $W;
                        $sessArray['Upload.artistUnique'] = $album['Artist']['unique'];
                        $sessArray['Upload.artistName'] = $album['Artist']['name'];
                        
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
                            $this->Session->setFlash(__('You have to select square photo for album.'),'default',array(),'flashError');
                        }else if (
                                
                                (!($this->Session->check('Upload.fileName'))&&
                                !($this->Session->check('Upload.artistUnique')))
                                ||
                                file_exists($file) == false
                            
                        ){
                            
                            $this->Session->setFlash(__('You have to select a file photo for album.'),'default',array(),'flashError');
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
        

        
    public function edit($unique = null) {

        if ($unique==null){throw new NotFoundException(__('Empty artist!'));}
        if (!$album=$this->Album->findByUnique($unique)) {throw new NotFoundException(__('Invalid album'));}
        if(!$this->Acl->check($this->group,'Album','update')&&!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));}


        

            $this->Album->unique=false;
            $this->Album->recursive=0;
            
                $this->Album->id=$id=$album['Album']['id'];
                $this->Album->artistUnique=$album['Artist']['unique'];
                $this->Album->artistId=$album['Artist']['id'];
                $this->set('title',$album['Artist']['name']."-".$album['Album']['title']);
                $this->set('letter', $this->HK->letter($album['Artist']['name']));
                $this->set('album',$album);

                if ($this->request->is(array('post', 'put'))) {
                    $this->request->data['Album']['title']=$this->HK->replaceSpecial($this->request->data['Album']['title']);
                    $dataArray['Album']['title']=h($this->request->data['Album']['title']);
                    if (!empty($this->request->data['Album']['year'])){
                            $dataArray['Album']['year'] = $this->request->data['Album']['year']; 
                        }

                    if ($this->Album->save($dataArray)) {

                        // notificarion 
                        if (!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){

                            $from = $this->Auth->user('id');
                            $to = $album['Album']['user_id'];
                            $noteId = 21;
                            $marks = array('albumTitle' => $album['Album']['title'],'albumUnique' => $album['Album']['unique'],'artistName' => $album['Artist']['name']);
                            $this->HK->notificate($from,$to,$noteId,$marks);


                        }
                    
                        // flash message 
                        $this->Session->setFlash(
                            __('The album %s for artist %s has been updated succefully.','<em>'.$album['Album']['title'].'<em>','<em>'.$album['Artist']['name'].'<em>'), //Message
                            'flash',                   //Element 
                            array(
                                'title' => __('Update status'),
                                'position'=>'top',
                                'velocity'=>200,
                                'delay'=>7777,
                                'type'=>'success'
                                )
                            );
                            return $this->redirect(array('controller'=>'artists','action' => 'index',$this->Album->artistUnique));

                }else {
                        $this->Session->setFlash(__('The album could not be saved. Please, try again.'),'default',array(),'flashError');

                }

                    } else {
                        $this->set('album',$album);
                        $options = array('conditions' => array('Album.' . $this->Album->primaryKey => $id));
                        $this->request->data = $album;
                }
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            
            
        if(!$this->Acl->check($this->group,'Album','delete')&&!$this->Album->isOwnedBy($id,$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));}        
        
        $this->Album->id = $id;
        
        if (!$this->Album->exists()) {throw new NotFoundException(__('Invalid album'));}
        $album = $this->Album->findById($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Album->del()) {
                        
            // notificarion 
            if (!$this->Album->isOwnedBy($album['Album']['id'],$this->Auth->user('id'))){

                $from = $this->Auth->user('id');
                $to = $album['Album']['user_id'];
                $noteId = 23;
                $marks = array('albumUnique' => $album['Album']['unique'],'albumTitle' => $album['Album']['title'],'artistName' => $album['Artist']['name']);
                $this->HK->notificate($from,$to,$noteId,$marks);

            }

            // flash message               
            $this->Session->setFlash(
                        __('The album %s for artist %s has been deleted.','<em>'.$album['Album']['title'].'</em>','<em>'.$album['Artist']['name'].'</em>'), //Message
                        'flash',                   //Element 
                        array(
                            'title' => __('Delete status'),
                            'position'=>'top',
                            'velocity'=>200,
                            'delay'=>7777,
                            'type'=>'warning'
                            )
                        );
                        return $this->redirect(array('controller'=>'artists','action' => 'index',$this->Album->artistUnique));
        } else {
            $this->Session->setFlash(__('The album could not be deleted. Please, try again.'),'default',array(),'flashError');
        }
            return $this->redirect(array('action' => 'index'));
	}
}
