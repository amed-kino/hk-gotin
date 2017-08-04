<?php



class  DownloadController extends AppController {

 
    
    

    public function beforeFilter() {
        
        parent::beforeFilter();
        $this->Auth->allow('index','lyric');
    
        
    }


    public function test(){
        

            
            $this->layout = 'pdf'; //this will use the pdf.ctp layout 
            
            $this->render('../Elements/FileTemplate/pdf_file');
    }

    public function index($unique=null) {
        
        $view = new View($this,false);
        $view->viewPath='Elements/FileTemplate';  
        $view->layout=false; 
        
        $html=$view->render('rtf_file' ); 
        var_dump($html);
              
        return $this->response;

    }
    public function lyric($type=null,$unique=null) {
        
    
        if ($unique==NULL){throw new NotFoundException(__('Invalid lyric.'));}
        
        if ($type==NULL){throw new NotFoundException(__('Invalid lyric.'));}
        $types=array(
            'pdf',
            'htm',
            'rtf',
            'txt',
            );
        if (!in_array($type, $types)){throw new NotFoundException(__('Invalid type.'));}
        
        $this->loadModel('Lyric');
        $lyric= $this->Lyric->findByUnique($unique);
        if ($lyric==NULL || empty($lyric)){throw new NotFoundException(__('Invalid lyric.'));}
        
        if ($type=='rtf'){
            $lyric['Lyric']['text']=str_replace('</br>',' ',$lyric['Lyric']['text']);
        }
        if ($type=='txt'){
            $lyric['Lyric']['text']=str_replace('</br>'," \r\n",$lyric['Lyric']['text']);
            $lyric['Lyric']['text']=str_replace(PHP_EOL," \r\n",$lyric['Lyric']['text']);
            $lyric['Lyric']['text']=str_replace('&lt;',' ',$lyric['Lyric']['text']);
            $lyric['Lyric']['text']=str_replace('&gt;',' ',$lyric['Lyric']['text']);
        }
        
        $view = new View($this,false);
        $view->viewPath='Elements/FileTemplate';  
        $view->layout=false; 

        $name_c = $lyric['Artist']['name'] . '-' . $lyric['Lyric']['title'];
        $name = 'HK '.$name_c;
        $date = new DateTime($lyric['Lyric']['modified']);
        
        $view->set('title',$name_c);
        $view->set('lyric',$lyric);
        $html=$view->render( $type . '_file' );
        
        $this->response->header('Last-Modified', $date->format('D, d M Y H:i:s') . ' GMT');
	$this->response->body($html); 
 	$this->response->type($type);
	$this->response->download( $name . '.' . $type );
	return $this->response;
        
    }

    
    
    }
