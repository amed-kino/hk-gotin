<?php
App::uses('AppController', 'Controller');
/**
 * Requests Controller
 *
 * @property Request $Request
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NotificationsController extends AppController {
    
    
    public $components=array();

    public function index() {
        
        $this->layout='preformance';
       
        var_dump($this->Notification->find('all'));
        }

  
}
