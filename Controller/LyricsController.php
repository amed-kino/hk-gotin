<?php
App::uses('AppController', 'Controller');
App::uses('HKComponent', 'Component');


class LyricsController extends AppController {

    
    
    private $user;
    private $group;    
//    public $components = array('Paginator','Tags');
    public $helpers=array('Paginator');

    
    public function beforeFilter() {
        
        parent::beforeFilter();
        $this->Auth->allow('latestAdd','recentEdit','popular','random','index','userLyrics','history','note','test');
        $user=$this->user = $this->Auth->user();
        $group=$this->Lyric->User->Group;
        $group->id = $user['Group']['id'];
        $this->group = $group;
    }

    private function isChanged($oldArray,$newArray){
        
        
        $returment=false;
        
        $intersectArray= array_intersect_key($oldArray,$newArray);
       
        if (isset($oldArray['text'])){

            $oldArray['text']=str_replace('</br>','',$oldArray['text']);
            $oldArray['text']=str_replace(chr(10),'',$oldArray['text']);
            $oldArray['text']=str_replace(PHP_EOL,'',$oldArray['text']);
            $oldArray['text'] = trim($oldArray['text']);
        }
        
        if (isset($newArray['text'])){

//            $newArray['text']=str_replace(PHP_EOL,'',$newArray['text']);
            $newArray['text']=str_replace(chr(10),'',$newArray['text']);            
            $newArray['text'] = trim($newArray['text']);
        }
        
        if (isset($oldArray['title'])){$oldArray['title']=$this->HK->smallizeLetter(trim($oldArray['title']));}
        if (isset($newArray['title'])){$newArray['title']=$this->HK->smallizeLetter(trim($newArray['title']));}
        if (isset($oldArray['writer'])){$oldArray['writer']=$this->HK->smallizeLetter(trim($oldArray['writer']));}
        if (isset($newArray['writer'])){$newArray['writer']=$this->HK->smallizeLetter(trim($newArray['writer']));}
        if (isset($oldArray['composer'])){$oldArray['composer']=$this->HK->smallizeLetter(trim($oldArray['composer']));}
        if (isset($newArray['composer'])){$newArray['composer']=$this->HK->smallizeLetter(trim($newArray['composer']));}


        foreach ($intersectArray as $key => $value){
           
            if ($oldArray[$key]!=$newArray[$key]){
                $returment=true;
                break;
            }
            
             
        }

        return $returment;
    }
    
    
    
/**
 * Checks if the current lyric is orginal.
 * @param $lyricId Lyric id to check.
 * @return bool true if there is no orginal in edit lyrics table.
 */
    
    private function isOrginal($lyricId = null){
        
        $this->loadModel('EditLyric');
        $EditLyric = $this->EditLyric->find('all',array(
                            'conditions' => array('EditLyric.lyric_id' => $lyricId, 'EditLyric.type' => 'orginal'),
                            'fields' => array('id'),
                        )
                );
        if(empty($EditLyric)){return true;}else{return false;}   
    }
    
    
    
    
/**
 * Checks if the current lyric is edited before.
 * @param $lyricId Lyric id to check.
 * @return bool true if there is there is an entery edit lyrics table.
 */
    
    private function isEdited($lyricId = null){
        
        $this->loadModel('EditLyric');
        $EditLyric = $this->EditLyric->find('all',array(
                            'conditions' => array('EditLyric.lyric_id' => $lyricId),
                            'fields' => array('id'),
                        )
                );
        
        if(empty($EditLyric)){return false;}else{return true;}   
    }
    
public function index($uriArtist=null,$uriAlbum=null,$uriTitle=null) {

        if ($this->HK->uniqueCheck($uriArtist)){
            $lyric = $this->Lyric->findByUnique($uriArtist);    
        }else{
            
            $redirectAlbum = FULL_BASE_URL.'/berhem/'.$uriArtist.'/'.$uriAlbum.'/';
            
            // check if title is set
            if ($uriTitle == null || $uriTitle == ''){    
                $this->redirect($redirectAlbum);
            }
            
            // set decode the title to pure text
            if (!($_title = $this->HK->uriDecoder($uriTitle))){
                $this->redirect($redirectAlbum);
            }
            
            // select the title from database.
            $_lyric = $this->Lyric->find('all',array(
                'conditions' => array('LOWER(Lyric.title)' => $_title),
            ));
            
            // 1 - check if $_lyric array is one single item
            if(sizeof($_lyric) == 1){
                $lyric = $_lyric[0];
            
            // 0 - if $_lyrcs array is empty
            }elseif(sizeof($_lyric) == 0){
                $this->redirect($redirectAlbum);
            
                
            // +1 - if $_lyric array is more than one.
            }else{                
                    if (!($_album = $this->HK->uriDecoder($uriAlbum,'album'))){$this->redirect($redirectAlbum);}
                    if (!($_year = $this->HK->uriDecoder($uriAlbum,'year'))){$this->redirect($redirectAlbum);}
                    if (!($_artist = $this->HK->uriDecoder($uriArtist))){$this->redirect($redirectAlbum);}
                    
                foreach ($_lyric as $key => $value){
                    
                    // Select the exact array for $lyric.
                    if (
                            (mb_strtolower ($value['Artist']['name']) == $_artist) &&
                            (mb_strtolower ($value['Album']['title']) == $_album) &&
                            (mb_strtolower ($value['Album']['year']) == $_year) &&
                            (           $value['Lyric']['deleted']) == 'no'
                            
                    ){
                        
                        $lyric = $value;
                        break;
                        
                    }   
                }
                
            }
        }
        
        
        
         if ($lyric==NULL || empty($lyric)){throw new NotFoundException(__('Invalid lyric.'));}
                
                $this->set('title', $lyric['Artist']['name']."-".$lyric['Lyric']['title']);
                $this->set('letter',$this->HK->letter($lyric['Artist']['name']));
                
                $editors = ($lyric['Lyric']['editors'])? $this->HK->editors($lyric['Lyric']['editors']):null;
                $lyric['Lyric']['midKurdishTitle'] = $this->HK->midKurdishAlphabit(' '.$lyric['Lyric']['title']);
                $lyric['Lyric']['midKurdishArtist'] = $this->HK->midKurdishAlphabit(' '.$lyric['Artist']['name']);
                $lyric['Lyric']['midKurdishAlbum'] = $this->HK->midKurdishAlphabit(' '.$lyric['Album']['title']);
                $lyric['Lyric']['midKurdishText'] = $this->HK->midKurdishAlphabit(' '.$lyric['Lyric']['text']);
                $this->set('lyric',$lyric);
                $this->set('editors',$editors);
//                $this->set('tags',$this->Tags->render($lyric['Lyric']['tags']));
                $this->Lyric->updateAll(
                    array('Lyric.views' => 'Lyric.views + 1'),  
                    array('Lyric.id' => $lyric['Lyric']['id'])  
                );


    }
    
    
    
    private function history_accept($id=null){
       
        if ($id==null){return false;}
        $this->EditLyric->recursive = -1;
        $editedLyric = $this->EditLyric->findById($id);

        $editData['Lyric']['title']    = $editedLyric['EditLyric']['title'];
        $editData['Lyric']['writer']   = $editedLyric['EditLyric']['writer'];
        $editData['Lyric']['composer'] = $editedLyric['EditLyric']['composer'];
        $editData['Lyric']['echelon']  = $editedLyric['EditLyric']['echelon'];
        $editData['Lyric']['text']     = $editedLyric['EditLyric']['text'];
        $editData['Lyric']['source']   = $editedLyric['EditLyric']['source'];
        
        $this->Lyric->unique = false;
        if ($this->Lyric->save($editData)) {
            if ($this->EditLyric->setCurrent($id)){
                if ($this->Lyric->addEditor($this->Lyric->id,$editedLyric['EditLyric']['user_id'])){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
          }else{
              return false;
          }
    }
    
    
    private function history_decline($id=null,$orginalId){
       
        if ($id==null){return false;}
        $this->EditLyric->recursive = -1;
        $editedLyric = $this->EditLyric->findById($orginalId);
        $declinedLyric = $this->EditLyric->findById($id);
        
        if ($declinedLyric['EditLyric']['type'] == 'current'){
           
            $editData['Lyric']['title']    = $editedLyric['EditLyric']['title'];
            $editData['Lyric']['writer']   = $editedLyric['EditLyric']['writer'];
            $editData['Lyric']['composer'] = $editedLyric['EditLyric']['composer'];
            $editData['Lyric']['echelon']  = $editedLyric['EditLyric']['echelon'];
            $editData['Lyric']['text']     = $editedLyric['EditLyric']['text'];
            $editData['Lyric']['source']   = $editedLyric['EditLyric']['source'];

            $this->Lyric->unique = false;
            if ($this->Lyric->save($editData)) {
                if ($this->EditLyric->setCurrent($orginalId)){
                    if ($this->EditLyric->setDeclined($id)){return true;}else{return false;}
                }else{
                    return false;
                }
              }else{
                  return false;
              }
              
        }else{
            
            if ($this->EditLyric->setDeclined($id)){return true;}else{return false;}
            
        }


    }

    
    public function history($unique=null,$id=null){
        
        if ($unique==null){throw new NotFoundException(__('Invalid lyric.'));}
        
        $lyric = $this->Lyric->findByUnique($unique); 
        if ($lyric==NULL || empty($lyric)){throw new NotFoundException(__('Invalid lyric.'));}
        $this->set('letter',$this->HK->letter($lyric['Artist']['name']));
                // Set $type variable ('changer' || 'requester'       


        $this->Lyric->id = $lyric['Lyric']['id'];
        $this->loadModel('EditLyric');
        $edits = $this->EditLyric->find('all',array('conditions'=>array('EditLyric.lyric_id' => $lyric['Lyric']['id'])));
        $orginalId = $edits[0]['EditLyric']['id'];
        
        $action = false;

        if ($this->Session->check('Auth.User')){
            if($this->Acl->check($this->group,'Lyric','update') || $this->Lyric->isOwnedBy($lyric['Lyric']['id'],$this->Auth->user('id'))){
                         $action = true;
            }
        }
        if (isset($this->request->params['named']['accept']) && $this->Session->check('Auth.User')){
            if (is_numeric($this->request->params['named']['accept'])){
                 if($action == false){
                     throw new NotFoundException(__('Invalid lyric.')); 
                 }
                
                if ($this->history_accept($this->request->params['named']['accept'])){
                                
                    $this->Session->setFlash(
                                    __('%s set to its new copy.','<strong>'.$lyric['Lyric']['title'].'</strong>'),
                                    'flash',
                                    array('title' => __('Edit status'),'position'=>'top','type'=>'success','velocity'=>400,'delay'=>5555,)
                        );
                    
                    return $this->redirect(array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique']));
                    
                } else {
                    $this->Session->setFlash(
                                __('%s could not be set to new version.','<strong>'.$lyric['Lyric']['title'].'</strong>'),
                                'flash',
                                array('title' => __('Edit status'),'position'=>'top','type'=>'danger','velocity'=>400,'delay'=>5555,)
                            );
                    return $this->redirect(array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique']));
                }
                
            }
        }else if(isset($this->request->params['named']['decline']) && $this->Session->check('Auth.User')){
            if (is_numeric($this->request->params['named']['decline'])){
                
                if($action == false){
                     throw new NotFoundException(__('Invalid lyric.')); 
                 }
                 
                $this->history_decline($this->request->params['named']['decline'],$orginalId);
                
                    $this->Session->setFlash(
                                    __('%s set to its previous copy.','<strong>'.$lyric['Lyric']['title'].'</strong>'),
                                    'flash',
                                    array('title' => __('Edit status'),'position'=>'top','type'=>'warning','velocity'=>400,'delay'=>5555,)
                        );
                    
                    return $this->redirect(array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique']));
                    
                } else {
                    $this->Session->setFlash(
                                __('%s could not be set to previous version.','<strong>'.$lyric['Lyric']['title'].'</strong>'),
                                'flash',
                                array('title' => __('Edit status'),'position'=>'top','type'=>'danger','velocity'=>400,'delay'=>5555,)
                            );
                    return $this->redirect(array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique']));
                }
        }else{
        
            $editsParam['lastCreated']= end($edits)['EditLyric']['created'];
            $editsParam['editsCounter']= sizeof($edits);

            $this->set('title',$lyric['Lyric']['title'].'-'.__('Edit history'));
            $this->set('lyric',$lyric);
            $this->set('edits',$edits);
            $this->set('action',$action);
            $this->set('currentId',$id);
            $this->set('editsParam',$editsParam);
    
        
        }
    }
    
    
    
    
    public function lyricslist() {
        
        
        $this->Paginator->settings['limit']=40;
        $this->Paginator->settings=array(
            'conditions' => array('Lyric.user_id' => $this->user['id']),
            'order' => 'Lyric.created DESC',
        );
        
        $this->Lyric->recursive = 1;
        

        
        
        $lyrics=$this->Lyric->find('all');
        
        $this->set('title',__('My Lyrics'));
        $this->set('lyrics', $this->Paginator->paginate());
    }

        
    public function random($limit=null){
        
        if ($limit==NULL || !is_numeric($limit)){throw new NotFoundException(__('Invalid limit.'));}
        if ($limit>100 || $limit<1){throw new NotFoundException(__('Invalid limit.'));}
        
       $random=$this->Lyric->find('all', array( 
                                        'conditions' => array('Lyric.available' => 'yes','Lyric.deleted' => 'no'), 
                                        'fields' => array(
                                                        'Artist.unique',
                                                        'Artist.name',
                                                        'Album.title',
                                                        'Album.year',
                                                        'Lyric.unique',
                                                        'Lyric.title',
                                                        'Lyric.created',
                                                        'Lyric.views',
                                                        'User.name',
                                                                        ),
                                        'order' => 'rand()',
                                        'limit' => $limit,
                                     ));
        if ($this->request->is('requested')) {
            return $random;
        }else{
            $this->set('random',$random);
        }
         
        $this->layout='preformance';
       
    }

        
    public function latestAdd(){
        if ($this->request->is('requested')) {
            $this->Lyric->recursive=0;
            $latest=$this->Lyric->find('all',array(
                'fields' => array(
                    'Lyric.unique',
                    'Lyric.title',
                    'Lyric.created',
                    'Album.title',
                    'Album.year',
                    'Artist.name',
                    ),
                'conditions'=>array('Lyric.available'=>'yes','Lyric.deleted' => 'no'),
                'order'=>array('Lyric.created DESC'),
                'limit'=>10,
            ));
                return $latest;
            }else{die();
            }
    }
    public function popular(){
        
        if ($this->request->is('requested')) {$latest=$this->Lyric->find('all',
                array(
                    
                'fields' => array(
                    'Lyric.unique',
                    'Lyric.title',
                    'Lyric.views',
                    'Album.title',
                    'Album.year',
                    'Artist.name',
                    ),
                'conditions'=>array('Lyric.available'=>'yes','Lyric.deleted' => 'no'),
                'order'=>array('Lyric.views DESC'),
                'limit'=>10,
            ));
                return $latest;
            }else{die();
            }
    }
    public function recentEdit(){
        
        if ($this->request->is('requested')) {$latest=$this->Lyric->find('all',
            array(
                'fields' => array(
                    'Lyric.unique',
                    'Lyric.title',
                    'Lyric.modified',
                    'Album.year',
                    'Album.title',
                    'Artist.name',
                    ),
                'conditions'=>array('Lyric.available'=>'yes','Lyric.deleted' => 'no'),
                'order'=>array('Lyric.modified DESC'),
                'limit'=>10,
            ));
                return $latest;
            }else{die();
            }
    }        


        

    public function userLyrics($unique=null,$type=null){
            
             if ($unique==null){return null;}            
            $user=$this->Lyric->User->findByUnique($unique);
            if ((empty($user['User']))){return null;}

            if ($type!=null){
                if ($type=='latest'){
                    
                    $options=array(
                                'conditions'=>array('Lyric.available'=>'yes','Lyric.user_id'=>$user['User']['id']),
                                'order'=>array('Lyric.created DESC'),
                                'limit'=>10,
                            );
                }else if($type=='popular'){
                    
                    $options=array(
                                'conditions'=>array('Lyric.available'=>'yes','Lyric.user_id'=>$user['User']['id'],'Lyric.deleted' => 'no'),
                                'order'=>array('Lyric.views DESC'),
                                'limit'=>10,
                            );
                }
                    $options['fields']=array(
                                            'Lyric.unique',
                                            'Lyric.title',
                                            'Lyric.unique',
                                            'Lyric.views',
                                            'Lyric.created',
                                            'Album.unique',
                                            'Album.title',
                                            'Album.year',
                                            'Artist.unique',
                                            'Artist.name',
                                    );
                    $userLyric=$this->Lyric->find('all',$options);
                    return $userLyric;
            }else{
                
                $userLyric=$this->Lyric->find('all',array(
                                                            'conditions'=>array('Lyric.available'=>'yes','Lyric.user_id'=>$user['User']['id'],'Lyric.deleted' => 'no'),
                                                            'order'=>array('Lyric.title ASC'),
                                                        )
                                                );
                return $userLyric;
            }
 
        }
       
        
        

    public function note($unique=null){

            if ($unique==null){throw new NotFoundException(__('Empty Lyric!'));}
            if (!$lyric=$this->Lyric->findByUnique($unique)) {throw new NotFoundException(__('Invalid lyric'));}
            $this->set('letter',$this->HK->letter($lyric['Artist']['name']));
            $this->set('lyric',$lyric);
            if ($this->request->is('post')){
                
                $data = $this->request->data['Request'];




                $dataArray = array();
                $dataArray['user_1']  = null;
                $dataArray['user_2']  = $lyric['User']['id'];
                $dataArray['message'] = h($this->HK->textSanitize($data['data']));
                $dataArray['related'] = h($this->HK->related('lyric',$lyric['Lyric']['unique']));

                $marksArray['name']  = h($this->HK->textSanitize($data['name']));
                $marksArray['email'] = h($this->HK->textSanitize($data['email']));

                $dataArray['marks']   = $this->HK->marks($marksArray);

                $this->loadModel('Message');    
                if ($this->Message->save($dataArray)){
                    $this->Session->setFlash(
                        __('Your inform has been sent successfully. Thank you.'),
                        'flash',
                        array(
                            'title' => __('Inform status'),
                            'position'=>'bottom',
                            'type'=>'success'
                            )
                        );
                         $this->redirect(array('controller'=>'lyrics','action' => 'index',$lyric['Lyric']['unique']));


                }else{
                    $this->Session->setFlash(__('The information could not be saved. Please, try again.'),'default',array(),'flashError');
                }

            }
        $this->set('title',__('Send a note'));
    }

    public function view() {
        throw new NotFoundException(__('Invalid lyric'));
    }



    public function add($section=null,$unique=null) {

        if ($section !=null){
            
            if ($section == 'artist'){
                $artistUnique = $unique;
                $albumUnique = null;
            }else if($section == 'album'){
                $albumUnique = $unique;
                $artistUnique = null;
            }

        }else{
            $artistUnique = null;
            $albumUnique = null;
        }
        
        if(!$this->Acl->check($this->group,'Lyric','create')){throw new NotFoundException(__('Not found'));}
        if ($this->Acl->check($this->group,'Lyric','update')){$available='yes';}else{$available='no';}

        if (isset($artistUnique)){
            $this->loadModel('Artist');
            $this->Artist->recursive=0;
            $artist=$this->Artist->findByUnique($artistUnique);
            $artistName = $artist['Artist']['name'];
            $albumTitle = '';
            if ($artist==null){throw new NotFoundException(__('Artist not found'));}
            $this->Lyric->artistId=$artist['Artist']['id'];
            $this->Lyric->artistUnique=$artist['Artist']['unique'];                
            $albums = $this->Lyric->Album->find('list',
                    array(
                        'conditions'=>array('available'=>'yes','Album.artist_id'=>$artist['Artist']['id']),
                        'order'=>array('Album.title COLLATE utf8_turkish_ci ASC')
                        )
                    );

                    if (empty($albums) || !isset($albums)){
                        $this->set('letter',$this->HK->letter($artist['Artist']['name']));
                        $this->set('artist',$artist['Artist']['name']);
                        $this->render('add_no_album');
                    }

        }
        if (isset($albumUnique)){
            $this->loadModel('Album');
            $this->Album->recursive=0;
            $album=$this->Album->findByUnique($albumUnique);
            $artistName = $album['Artist']['name'];
            $albumTitle = $album['Album']['title'];
            if ($album==null){throw new NotFoundException(__('Album not found'));}
            $this->Lyric->artistId=$album['Artist']['id'];
            $this->Lyric->albumId=$album['Album']['id'];
            $this->Lyric->artistUnique=$album['Artist']['unique']; 
        }

        if ($this->request->is('post')) {

            $this->request->data['Lyric']['title']=$this->HK->replaceSpecial($this->request->data['Lyric']['title']);
            $this->request->data['Lyric']['writer']=$this->HK->replaceSpecial($this->request->data['Lyric']['writer']);
            $this->request->data['Lyric']['composer']=$this->HK->replaceSpecial($this->request->data['Lyric']['composer']);
            $text =  $this->HK->textSanitize($this->request->data['Lyric']['text']);

            $this->Lyric->create();

            $dataArray=array();

            if ($artistUnique){
                $dataArray['Lyric']['album_id']=(int)($this->request->data['Lyric']['album_id']);
                $dataArray['Lyric']['artist_id']=(int)($this->Lyric->artistId);
                
            }else if ($albumUnique){
                $dataArray['Lyric']['album_id']=(int)($this->Lyric->albumId);
                $dataArray['Lyric']['artist_id']=(int)($this->Lyric->artistId);
            }else{

                $this->Lyric->Artist->recursive=-1;
                $this->Lyric->Album->recursive=-1;
                
                

                $_artist=$this->Lyric->Artist->findByUnique($this->request->data['artist_unique'],array('id','unique','name'));
                if ($_artist!=null || !empty($_artist)){
                    $this->set('c_artist_name',$_artist['Artist']['name']);
                    $this->set('c_artist_unique',$_artist['Artist']['unique']);
                    $artist_id=$this->request->data['Lyric']['artist_id']=$_artist['Artist']['id'];
                    $artistName = $_artist['Artist']['name'];
                }else{die('^_^');}
                    
                    

                $_album=$this->Lyric->Album->findByUnique($this->request->data['album_unique'],array('id','unique','title'));
                if ($_album!=null || !empty($_album)){
                    $this->set('c_album_title',$_album['Album']['title']);
                    $this->set('c_album_unique',$_album['Album']['unique']);
                    $album_id=$this->request->data['Lyric']['album_id']=$_album['Album']['id'];
                    $albumTitle = $_album['Album']['title'];
                }else{die('^_^');}
                
                $dataArray['Lyric']['artist_id']=(int)($artist_id);
                $dataArray['Lyric']['album_id']=(int)($album_id);

            }
            
            $dataArray['Lyric']['unique']=$this->Lyric->unique;
            $dataArray['Lyric']['title']=$this->HK->replaceSpecial(h($this->request->data['Lyric']['title']));            
            $dataArray['Lyric']['writer']=$this->HK->replaceSpecial(h($this->request->data['Lyric']['writer']));
            $dataArray['Lyric']['composer']=$this->HK->replaceSpecial(h($this->request->data['Lyric']['composer']));
            $dataArray['Lyric']['echelon']=h($this->request->data['Lyric']['echelon']);
            $dataArray['Lyric']['text']=$text;
            $dataArray['Lyric']['source'] = h($this->request->data['Lyric']['source']);
            $dataArray['Lyric']['modified']='0000-00-00 00:00:00';
            $dataArray['Lyric']['available']=$available;
            $dataArray['Lyric']['user_id']=$this->Auth->user('id');


            if ($this->Lyric->save($dataArray)) {

                $this->Session->setFlash(
                            __('Your lyric %s has been added to %s successfully.','<em>'.h($dataArray['Lyric']['title']).'</em>','<em>'.$artistName.' '.$albumTitle.'</em>'),
                            'flash',                   //Element 
                            array(
                                'title' => 'Saved',
                                'position'=>'top',
                                'velocity'=>200,
                                'delay'=>7777,
                                'type'=>'success'
                                )
                            );
                return $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->unique));
            } else {
                $this->Session->setFlash(__('The lyric could not be saved. Please, try again.'),'default',array(),'flashError');
            }
        }


        if ($artistUnique){

             if (empty($albums) || !isset($albums)){

                    $this->set('artist',$artist);
                    $this->set('title',$artist['Artist']['name']."-".__('Add lyric'));        
                    $this->render('add_no_album');

                }else{

                    $this->set('title',$artist['Artist']['name']."-".__('Add lyric'));
                    $this->set('letter',$this->HK->letter($artist['Artist']['name']));
                    $this->set(compact('albums'));
                    $this->set('artist',$artist);
                    $this->render('add_artist');
                }

        }elseif (isset($albumUnique)){
            $this->set('letter',$this->HK->letter($album['Artist']['name']));
            $this->set('title',$album['Artist']['name']."-".__('Add lyric'));        
            $this->set('album',$album);
            $this->render('add_album');


        }else{
            
            $artists = $this->Lyric->Artist->find('list',
                    array(
                        'conditions' => array('Artist.available'=>'yes','Artist.deleted'=>'no'),
                        'order' => array('Artist.name COLLATE utf8_turkish_ci ASC'),
                        'fields' => array('unique','name'),
                        
                        )
                    );            

            $this->set(compact('artists'));
            $this->set(compact('albums'));
            $this->set('title',__('Add lyric'));
        }
    }

 
    
    private function edit_save_orginal_lyric() {
    
        $this->EditLyric->create();
        
        if (!$this->EditLyric->saveOrginal($lyric['Lyric'])){
        
            die('SAVE_ORGINAL_ERROR');
            
        }
        
        return TRUE;
    }
    
    
    private function edit_save_lyric($dataArray) {
        
        
        if ($this->Lyric->save($dataArray)) {
            
            $this->Session->setFlash(
                    __('Lyric has been updated.'),
                    'flash',
                    array('title' => __('Edit status'),'position'=>'top','type'=>'success'));

            return $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));

           }


        
    }
    
    private function edit_lyric_edit_check() {
        
        
        
        $this->EditLyric->recursive = -1;
        $lyricEdits = $this->EditLyric->find('all',array('conditions'=>array('lyric_id'=>$this->Lyric->edit['Lyric']['id'])));
      
        
        
            // Checks if there is edits before in DB.
            if (!empty($lyricEdits)){

                
                // There are edits before.
                $this->EditLyric->edit['_edits'] = true;
                
 
                foreach ($lyricEdits as $key => $value) {

                    if(!$this->isChanged($this->edit_array_leach($value['EditLyric']),$this->edit_array_leach($this->request->data['Lyric']))){
                        
                        // There are an edit that matchs this edit.
                        
                        $this->EditLyric->edit['_requested'] = true;
                        $this->EditLyric->edit['referenceLyric'] = $value['EditLyric'];
                        
                        
                    }
                    
                    
               }
               
            }
    }
    
    
    private function edit_request_normal(){
                    
            $this->request->data = $this->Lyric->edit;
            $this->set('lyric',$this->Lyric->edit);
            $this->set('title',__('Edit %s',$this->Lyric->edit['Lyric']['title']));
            $this->set('letter',$this->HK->letter($this->Lyric->edit['Artist']['name']));
            
    }
    
    private function edit_request_post() {

              
        
        $dataArray['Lyric'] = $this->edit_array_leach($this->request->data['Lyric']);
                 
        $this->Lyric->unique = false;
        
        // History register trigger (see if hide history is selected)
        if ($this->Acl->check($this->group,'Lyric','update')){
            if (isset($this->request->data['Lyric']['history'])){
                if ($this->request->data['Lyric']['history'] == 'hide'){
                    $historyHide = true;
                }else{
                    $historyHide = false;
                }
            }
        }
        
        // if instant save is requested from an admin
        // (that means that the edit will not be registerd)
        if (isset($historyHide) && $historyHide == true){
        
            $this->edit_save_lyric($dataArray);
        

        // if the show edit is requested 
        // (default edit that makes all eidts visible in edit panel)
        }else{
           
              if(!$this->isChanged($this->Lyric->edit['Lyric'],$this->request->data['Lyric'])){
                  $this->Session->setFlash(__('There is no edit actions found. Please try again.'),'default',array(),'flashError');
                  $this->edit_request_normal();
              }else{
                  
                // Lyric been changed.

                // Load the EditLyric model that contains all the edits.  
                $this->loadModel('EditLyric');
                
                // There are no previous changes (Default set).
                $this->EditLyric->edit['_requested'] = false;
                $this->EditLyric->edit['_edits'] = false;
                  
                //Check if it is in the database before.
                $this->edit_lyric_edit_check();

                // There is no orginal copy in edit lyric table.
                if ($this->EditLyric->edit['_edits'] === false){
                    $this->edit_save_orginal_lyric($this->Lyric->edit['Lyric']);
                }
                
               
                // Set $type variable ('changer' || 'requester')
                if(
                        !$this->Acl->check($this->group,'Lyric','update')&&
                        !$this->Lyric->isOwnedBy($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'))
                    )   
                        {
                            
                            $this->EditLyric->edit['userType'] = 'requester';
                            
                        }else{
                            
                            $this->EditLyric->edit['userType'] = 'changer';
                            
                        }

                
                //The specified edit is already been sent before.
                if ($this->EditLyric->edit['_requested'] == true){
                    
                    
                  
                    $this->EditLyric->edit['moreLink'] = Router::url(array('controller' =>'lyrics','action' => 'history',$this->Lyric->edit['Lyric']['unique'],$this->EditLyric->edit['referenceLyric']['id']), true);
                    $this->EditLyric->edit['moreDetails'] = __('More details');
                    
                    
                    
                    // See what type of the edit is the edited lyric (that is saved in EditLyric).

                        // The edited lyric is orginal versoin.
                        if ($this->EditLyric->edit['referenceLyric']['type'] == 'orginal'){

                            $this->edit_request_post_type_orginal();

                        // The edited lyric is current lyric.
                        }else if($this->EditLyric->edit['referenceLyric']['type'] == 'current'){

                            $this->edit_request_post_type_current();
                            
                            
                        // The edited lyric is just edit (it has been sent before).
                        }else{

                        // Check the type of the user.

                            //if it's a requester.
                            if ($this->EditLyric->edit['userType'] == 'requester'){

                                $this->edit_request_post_type_requester('exists');
                            
                            
                            //set the new value with name of the editor in Editor field.    
                            //if it's a changer.
                            }else{
                                
                                $this->edit_request_post_type_changer('exists');
                                
                                
                            }
                         
                        }
                        
                // if the edits are new
                }else{

                // Check the type of the user.

                    //if it's a requester.
                    if ($this->EditLyric->edit['userType'] == 'requester'){

                        $this->edit_request_post_type_requester('new');


                    //set the new value with name of the editor in Editor field.    
                    //if it's a changer.
                    }else{

                        $this->edit_request_post_type_changer('new');


                    }

                }

              }
            
        }
        
        
        
        
    }
    
    
    private function edit_request_post_type_orginal(){
     
        
       
       if ($this->EditLyric->edit['userType'] == 'changer'){
            $editData = $this->edit_array_leach($this->request->data['Lyric']);
            if ($this->Lyric->save($editData)) {

                     $this->EditLyric->setCurrent($this->EditLyric->edit['referenceLyric']['id']);

                     // notificarion 
                     if (!$this->Lyric->isOwnedBy($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'))){
                         $from = $this->Auth->user('id');
                         $to = $this->Lyric->edit['Lyric']['user_id'];
                         $noteId = 31;
                         $marks = array('lyricUnique' => $this->Lyric->edit['Lyric']['unique'],'lyricTitle' => $this->Lyric->edit['Lyric']['title'],'artistName' => $this->Lyric->edit['Artist']['name']);
                         $this->HK->notificate($from,$to,$noteId,$marks);
                     }
            }
       
        }
       
        $this->Session->setFlash(
            __('This change request is the orginal copy. %s','<a href="'.$this->EditLyric->edit['moreLink'].'">'.$this->EditLyric->edit['moreDetails'].'</a>'),
            'flash',
            array('title' => __('Edit status'),'position'=>'top','type'=>'warning','velocity'=>400,'delay'=>9999,
        ));

        $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));
    }
    
    
    private function edit_request_post_type_current(){
        $this->Session->setFlash(
                __('This change request is to the current copy. %s','<a href="'.$this->EditLyric->edit['moreLink'].'">'.$this->EditLyric->edit['moreDetails'].'</a>'),
                'flash',
                array('title' => __('Edit status'),'position'=>'top','type'=>'warning','velocity'=>400,'delay'=>9999,
             ));

        $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));
    }
    
    
    private function edit_request_post_type_requester($lyricEditType){
        
       
        if ($lyricEditType == 'exists'){
       
            $this->Session->setFlash(
                __('This change request is already been sent before. %s','<a href="'.$this->EditLyric->edit['moreLink'].'">'.$this->EditLyric->edit['moreDetails'].'</a>'),
                'flash',
                array('title' => __('Edit status'),'position'=>'top','type'=>'warning','velocity'=>400,'delay'=>9999,
             ));
            
            $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));
        }
        
        if ($lyricEditType == 'new'){
            
                
            $editedLyric = $this->edit_array_leach($this->request->data['Lyric']);
            $editedLyric['id'] = $this->Lyric->edit['Lyric']['id'];
                $this->EditLyric->create();

                if ($this->EditLyric->saveEdit($editedLyric,$this->Auth->user('id'),'edit')) {


                // notificarion 
                    if (!$this->Lyric->isOwnedBy($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'))){

                        $from = $this->Auth->user('id');
                        $to = $this->Lyric->edit['Lyric']['user_id'];
                        $noteId = 32;
                        $marks = array('lyricUnique' => $this->Lyric->edit['Lyric']['unique'],'lyricTitle' => $this->Lyric->edit['Lyric']['title'],'artistName' => $this->Lyric->edit['Artist']['name'],'editLyricId' =>$this->EditLyric->id);
                        $this->HK->notificate($from,$to,$noteId,$marks);

                    }
                        // flash message 
                    $this->Session->setFlash(
                                __('Lyric chang request have been sent to the owner of this lyric,you have to wait for approval.'),
                                'flash',
                                array('title' => __('Edit status'),'position'=>'top','type'=>'info','velocity'=>400,'delay'=>9999,)
                    );
                    
                    return $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));

               }    else{$this->Session->setFlash(__('The lyric request could not be sent. Please, try again.'),'default',array(),'flashError');}

        }
        
        

    }
    
    private function edit_request_post_type_changer($lyricEditType){
        
        $editData = $this->edit_array_leach($this->request->data['Lyric']);
        
        if ($lyricEditType == 'exists'){
           
                if ($this->Lyric->save($editData)) {
                    
                    $this->EditLyric->setCurrent($this->EditLyric->edit['referenceLyric']['id']);
                   
                    // notificarion 
                    if (!$this->Lyric->isOwnedBy($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'))){
                        $from = $this->Auth->user('id');
                        $to = $this->Lyric->edit['Lyric']['user_id'];
                        $noteId = 31;
                        $marks = array('lyricUnique' => $this->Lyric->edit['Lyric']['unique'],'lyricTitle' => $this->Lyric->edit['Lyric']['title'],'artistName' => $this->Lyric->edit['Artist']['name']);
                        $this->HK->notificate($from,$to,$noteId,$marks);
                    }
                    
                    // flash message 
                   
                    $this->Session->setFlash(
                        __('This change request is already been sent before. %s','<a href="'.$this->EditLyric->edit['moreLink'].'">'.$this->EditLyric->edit['moreDetails'].'</a>'),
                        'flash',
                        array('title' => __('Edit status'),'position'=>'top','type'=>'success'));

                    return $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));

                }else{

                    $this->Session->setFlash(__('The lyric could not be saved. Please, try again.'),'default',array(),'flashError');

                }            
            
        }

        if ($lyricEditType == 'new'){
                                    
            if ($this->Lyric->save($editData)) {

                $this->EditLyric->create();
                $this->EditLyric->saveEdit($this->Lyric->edit['Lyric'],$this->Auth->user('id'),'current');
                $this->Lyric->addEditor($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'));

                $this->EditLyric->setCurrent($this->EditLyric->id);

                // notificarion 
                if (!$this->Lyric->isOwnedBy($this->Lyric->edit['Lyric']['id'],$this->Auth->user('id'))){

                    $from = $this->Auth->user('id');
                    $to = $this->Lyric->edit['Lyric']['user_id'];
                    $noteId = 31;
                    $marks = array('lyricUnique' => $this->Lyric->edit['Lyric']['unique'],'lyricTitle' => $this->Lyric->edit['Lyric']['title'],'artistName' => $this->Lyric->edit['Artist']['name']);
                    $this->HK->notificate($from,$to,$noteId,$marks);

                }

                // flash message 
                $this->Session->setFlash(
                        __('Lyric has been updated.'),
                        'flash',
                        array('title' => __('Edit status'),'position'=>'top','type'=>'success'));

                return $this->redirect(array('controller'=>'lyrics','action' => 'index',$this->Lyric->edit['Lyric']['unique']));

               }    else{$this->Session->setFlash(__('The lyric could not be saved. Please, try again.'),'default',array(),'flashError');}




        }
                
        
    }
    
    

    public function edit($unique = null) {
        
        if ($unique == null){throw new NotFoundException(__('Empty Lyric!'));}
        if (!$lyric = $this->Lyric->findByUnique($unique)) {throw new NotFoundException(__('Invalid lyric'));}

        $this->Lyric->edit = $lyric;
        $this->Lyric->id = $lyric['Lyric']['id'];
        $this->Lyric->id = $lyric['Lyric']['id'];
        $this->Lyric->albumId = $lyric['Lyric']['album_id'];
        $this->Lyric->unique = $lyric['Lyric']['unique'];
        
        // Post handler.
        
        if ($this->request->is(array('post', 'put'))) {
            $this->edit_request_post();
        }else{
            $this->edit_request_normal();
        }
//        var_dump($this->Lyric->edit);
//        var_dump($this->EditLyric->edit);
    }
    
	
    private function edit_array_leach($dataArray){
        
            $returnData['title']    = @$dataArray['title'];
            $returnData['writer']   = @$dataArray['writer'];
            $returnData['composer'] = @$dataArray['composer'];
            $returnData['echelon']  = @$dataArray['echelon'];
            $returnData['text']     = @$dataArray['text'];
            $returnData['source']   = @$dataArray['source'];
                         
            return $returnData;
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            
            
                    
            if(!$this->Acl->check($this->group,'Lyric','delete')&&!$this->Lyric->isOwnedBy($id,$this->Auth->user('id'))){throw new NotFoundException(__('Not found'));}            
            
            $this->Lyric->id = $id;
            
            if (!$this->Lyric->exists()) {throw new NotFoundException(__('Invalid lyric'));}
            
                $this->Lyric->recursive=0;
                $lyric=$this->Lyric->findById($id);
                $this->Lyric->artistUnique=$lyric['Artist']['unique'];
                
                    if ($this->Lyric->del()) {
                        
                        // notificarion 
                        if (!$this->Lyric->isOwnedBy($lyric['Lyric']['id'],$this->Auth->user('id'))){

                            $from = $this->Auth->user('id');
                            $to = $lyric['Lyric']['user_id'];
                            $noteId = 33;
                            $marks = array('lyricUnique' => $lyric['Lyric']['unique'],'lyricTitle' => $lyric['Lyric']['title'],'artistName' => $lyric['Artist']['name']);
                            $this->HK->notificate($from,$to,$noteId,$marks);

                        }

                        // flash message                         
                        $this->Session->setFlash(
                            __('The lyric %s has been deleted.', $lyric['Lyric']['title']), //Message
                            'flash',                   //Element 
                            array(
                                'title' => __('Delete status'),
                                'position'=>'top',
                                'type'=>'warning'
                                )
                            );
                            return $this->redirect(array('controller'=>'artists','action' => 'index',$this->Lyric->artistUnique));
                        } else {
                            $this->Session->setFlash(__('The lyric could not be deleted. Please, try again.'),'default',array(),'flashError');
                        }
                
                
		return $this->redirect(array('action' => 'index'));
	}

        
        
        
}