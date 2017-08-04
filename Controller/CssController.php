<?php
    class CssController extends AppController {

    public function beforeFilter() {
        
        
        $this->layout = 'css';
        $this->Auth->allow();
                parent::beforeFilter();
    }

    public function index($query = null) {
                $this->render(FALSE);
            }
    
    
    public function auto($query = null) {
        
        $request = $this->request->query;
        
        // Player CDN
            if ($query == 'player'){
                if (isset($request['stran'])){
                    
                    $this->player($request['stran']);
                }else{$this->render(FALSE);}
            }else{
                $this->render(FALSE);
            }

        }
            
        private function  player($data){
            $this->set('file',$data);
            $this->render('player');
            
        }
    }
        