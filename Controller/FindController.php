<?php
App::uses('AppController', 'Controller');

class FindController extends AppController {
    
  public $components = array('Paginator','HK');
  public $helpers=array('Html','Form','Text');
  
  


public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow();
}


public function prg(){
    
    //request is post.
    if ($this->request->is('post')){
       
        //key passrd to post.
        if (isset($this->request->data['Find']['key'])){
        $key=trim($this->request->data['Find']['key']);
        $key=$this->HK->replaceSpecial($key);
            if (strlen($key)>=2 && $this->HK->isKurdish($key)){
                $params['key']=$key;
                $this->redirect($params);
            }else{
                $this->Session->setFlash(__('Try to add more specified key.'),'default',array(),'flashError');
                $this->redirect(array('controller'=>'find','action'=>'index'));
           }
           
           
        //advanced array passed to post.
        }else if(isset($this->request->data['Find']['advanced'])){
            return false;
            
        //key not key nor advanced array passed to post.
        }else{
            $this->redirect(array('controller'=>'find','action'=>'index'));
        }
    
    //Request is get
    }else{
        
        //if key passed through get.
        if (isset($this->request->params['named']['key'])){
        $this->request->data['Find']['key']=$this->request->params['named']['key'];

        }elseif (isset($this->request->params['named']['advanced'])){

        }

    }
}











  public function index() {

        $this->prg();
        $section='general';
        $this->set('active','general');
        
        
        if (isset($this->request->params['key'])){
            $key = trim($this->request->params['key']);
            
            $key = $this->HK->replaceSpecial($key);      
            $key = $this->HK->capitalizeLetter($key);
                if (strlen($key)>=2 && $this->HK->isKurdish($key)){
                    
                    if (isset($this->passedArgs['section'])){
                        $section=$this->passedArgs['section'];
                    }
                        

                    if (isset($section)){if ($section=='artists'){$this->set('active','artist');}elseif($section=='albums'){$this->set('active','album');}elseif($section=='lyrics'){$this->set('active','lyric');}
                    }else{}

                //Secured Place to start search procedure.
                $this->set('key',$key);
                $this->set('section',$section);
                $this->set('title',$key);
                
                $this->Find->Artist->recursive=0;
                $this->Find->Album->recursive=0;
                $this->Find->Lyric->recursive=0;
                    
        //Artist Search.

        
        $searchTerm = '%' . $key . '%';
        
        if ($section=='artists'){$this->Paginator->settings['Artist']['limit'] = 12;}else{$this->Paginator->settings['Artist']['limit'] = 5;}
        $this->Paginator->settings['Artist']['conditions'] = array(
            'Artist.available' => 'yes',
            'Artist.deleted' => 'no',            
            'LOWER(Artist.name COLLATE utf8_general_ci) LIKE' => $searchTerm.''
            );
        if ($section=='albums'){$this->Paginator->settings['Album']['limit'] = 12;}else{$this->Paginator->settings['Album']['limit'] = 5;}
        $this->Paginator->settings['Album']['conditions'] = array(
            
            'Album.available' => 'yes',
            'Album.deleted' => 'no',
            'LOWER(Album.title COLLATE utf8_general_ci) LIKE' => $searchTerm.''
            
            );
        
        if ($section=='lyrics'){$this->Paginator->settings['Lyric']['limit'] = 12;}else{$this->Paginator->settings['Lyric']['limit'] = 5;}
        $this->Paginator->settings['Lyric']['conditions'] = array('Lyric.available' => 'yes', 'Lyric.deleted' => 'no');
        $this->Paginator->settings['Lyric']['conditions']= array(
            'or' =>array(
            array ('LOWER(Lyric.text COLLATE utf8_general_ci) LIKE' => $searchTerm.'',),
            array ('LOWER(Lyric.title COLLATE utf8_general_ci) LIKE' => $searchTerm.''),
            ));

                if ($section=='artists'){
                    
                    
                    
                    $artists=$this->Paginator->paginate('Find.Artist');
                    $this->set('artists',$artists);
                    $artists_params=$this->request->params['paging']['Artist'];
                    $this->set('artists_params',$artists_params);
                    
                    $albumsCounts=$this->Find->Album->find('count',array('conditions'=>$this->Paginator->settings['Album']['conditions']));
                    $albums_params['count']=$albumsCounts;
                    $this->set('albums_params',$albums_params);
                    
                    $lyricsCounts=$this->Find->Lyric->find('count',array('conditions'=>$this->Paginator->settings['Lyric']['conditions']));
                    $lyrics_params['count']=$lyricsCounts;
                    $this->set('lyrics_params',$lyrics_params);
                    
                    $this->set('title',__('Artists Search').' '.$key);
                    $this->render('find_artist');
                    
                    
                    
                    
                    
                }else if($section=='albums'){
                    
                    
                    $artistsCounts=$this->Find->Artist->find('count',array('conditions'=>$this->Paginator->settings['Artist']['conditions']));
                    $artists_params['count']=$artistsCounts;
                    $this->set('artists_params',$artists_params);
                    
                    $albums=$this->Paginator->paginate('Album');
                    $this->set('albums',$albums);
                    $albums_params=$this->request->params['paging']['Album'];
                    $this->set('albums_params',$albums_params);            
                    
                    $lyricsCounts=$this->Find->Lyric->find('count',array('conditions'=>$this->Paginator->settings['Lyric']['conditions']));
                    $lyrics_params['count']=$lyricsCounts;
                    $this->set('lyrics_params',$lyrics_params);
                    
                    $this->set('title',__('Albums Search').' '.$key);
                    $this->render('find_album');
                  
                    
                    
                }else if($section=='lyrics'){
                    
                    
                    $artistsCounts=$this->Find->Artist->find('count',array('conditions'=>$this->Paginator->settings['Artist']['conditions']));
                    $artists_params['count']=$artistsCounts;
                    $this->set('artists_params',$artists_params);
                    
                    $albumsCounts=$this->Find->Album->find('count',array('conditions'=>$this->Paginator->settings['Album']['conditions']));
                    $albums_params['count']=$albumsCounts;
                    $this->set('albums_params',$albums_params);
                    
                    $lyrics=$this->Paginator->paginate('Lyric');
                    $this->set('lyrics',$lyrics);
                    $lyrics_params=$this->request->params['paging']['Lyric'];
                    $this->set('lyrics_params',$lyrics_params);     
                                
                    $this->set('title',__('Lyrics Search').' '.$key);
                    $this->render('find_lyric'); 
                    
                    
                    
                    
                    
                }else{
                    
                    $artists=$this->Paginator->paginate('Find.Artist');
                    $this->set('artists',$artists);
                    $artists_params=$this->request->params['paging']['Artist'];
                    $this->set('artists_params',$artists_params);
                    $albums=$this->Paginator->paginate('Album');
                    $this->set('albums',$albums);
                    $albums_params=$this->request->params['paging']['Album'];
                    $this->set('albums_params',$albums_params);            
                    $lyrics=$this->Paginator->paginate('Lyric');
                    $this->set('lyrics',$lyrics);
                    $lyrics_params=$this->request->params['paging']['Lyric'];
                    $this->set('lyrics_params',$lyrics_params);
                    // When the search results are 0;
                    if ($artists_params['count'] == 0 && $albums_params['count'] == 0 && $lyrics_params['count'] == 0){
                        
                        $this->render('empty');
                        
                    }else{
                        
                        $this->render('find');
                        
                    }
                    
                    
                }
            
                   
        }else{
            
            die();
            //when the returnment is not well maded.
            $this->set('title',__('Specify keyword'));
            $this->Session->setFlash(__('Try to add more specified key.'),'default',array(),'flashError');
            $this->redirect(array('controller'=>'find','action'=>'index'),'default',array(),'flashError');
            $this->render('empty');
        }


            //advanced array passed to post.
        
        }else{
            // When just page been showed.
            $this->set('title',__('Specify keyword'));
            
        }
        
     
      
  }
      public function find_artist(){
          
          
      }
      
      public function find_album(){
          
          
      }
      
      public function find_lyric(){
          
         
}
      
  }

  
  



