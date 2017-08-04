<?php
App::uses('AppController', 'Controller');
/**
 * Requests Controller
 *
 * @property Request $Request
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MessagesController extends AppController {
    
    
    public $components=array();

    public function index() {
        
        $this->layout='preformance';

//        var_dump($this->HK->messages(1));
        
         $optionsArray=array();
        
         
        $optionsArray['conditions']=array('Message.user_2' => 2);

        $this->Message->recursive=2;
        var_dump($this->Message->find('all'));
       
        }

  
}
