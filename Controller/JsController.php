<?php
    class JsController extends AppController {

    public function beforeFilter() {
        $this->layout = 'js';
        $this->Auth->allow();
                parent::beforeFilter();

    }

    public function index($query = null) {
                $this->render(FALSE);                
            }
    
    
    public function auto($query = null) {
        
        $request = $this->request->query;
        
        // Player CDN
        // If the query is only playr with file.
            if ($query == 'player'){
                
                
                if (isset($request['stran'])){
                    
                if (strstr($request['stran'], 'http') == false){
                    
                    $stran = FULL_BASE_URL . '/' . 'stran' . '/' . $request['stran'];
  
                }else{
                    $stran = $request['stran'];
                }
                    
                    $this->player($stran);
                    
                }else{
                    
                    $this->render(FALSE);
                    
                }
                
        // Playlist CDN
        // If the query is playlist.
            }else if($query == 'playlist'){
                
                if (isset($request['direji']) && is_numeric($request['direji'])){
                   
                        $this->playList($request['direji']);
                    
                }else if (isset($request['berhem']) && $this->HK->uniqueCheck($request['berhem'])){
                    $this->album($request['berhem']);
                }else{
                    
                    $this->render(FALSE);
                    
                }
            }else{
                $this->render(FALSE);
            }

        }
            
        private function player($data){
            
            
            $this->set('file',$data);
            $this->render('player');
            
        }
        
        private function requestRandom($length){
            return $this->requestAction(array('controller' => 'player', 'action' => 'songs','random',$length));
        }
        private function  playList($length){
            
            if (!is_numeric($length) || $length>100 || $length<1){throw new NotFoundException(__('Invalid limit.'));}
            
            $data_ = $this->requestRandom($length);
            $data = array();
            
            foreach ($data_ as $data_item) {
                
                
                $data['artistUnique'] = $data_item['Artist']['unique'];
                $data['artistName'] =   $data_item['Artist']['name'];
                
                $data['albumImage'] =   'hunermend/'.$data_item['Artist']['image'];

                $data['albumTitle'] =   $data_item['Album']['title'];
                $data['albumYear'] =    $data_item['Album']['year'];

                $data['lyricUnique'] =  $data_item['Lyric']['unique'];
                $data['lyricTitle'] =   $data_item['Lyric']['title'];
                $data['lyricFile'] =    $data_item['Lyric']['file'];
                
                
                $data_c[] = $data;
            }
            
           
            $this->set('data',$data_c);
            $this->set('length',$length);
            $this->render('Playlist');
            
        }
        
        
        private function  album($length){
            
          
            
            $data_ = $this->requestAction(array('controller' => 'player', 'action' => 'songs','album',$length));
            if (empty($data_)){
                $data_ = $this->requestRandom($length);
            }
            $data = array();
            
            foreach ($data_ as $data_item) {
                
                
                $data['artistUnique'] = $data_item['Artist']['unique'];
                $data['artistName'] =   $data_item['Artist']['name'];

                $data['albumTitle'] =   $data_item['Album']['title'];
                $data['albumYear'] =    $data_item['Album']['year'];
//                $data['albumImage'] =   $data_item['Album']['image'];
                $data['albumImage'] =   'berhem/'.$data_item['Album']['image'];

                $data['lyricUnique'] =  $data_item['Lyric']['unique'];
                $data['lyricTitle'] =   $data_item['Lyric']['title'];
                $data['lyricFile'] =    $data_item['Lyric']['file'];
                
                
                $data_c[] = $data;
            }
            
           
            $this->set('data',$data_c);
            $this->set('length',$length);
            $this->render('Playlist');
            
        }
    }
        