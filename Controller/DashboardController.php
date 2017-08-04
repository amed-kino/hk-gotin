<?php
App::uses('AppController', 'Controller');
/**
 * Requests Controller
 *
 * @property Request $Request
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DashboardController extends AppController {
    
    
    public $components = array('Paginator');
    public $helpers = array('Paginator');
        
    

    
    public function beforeFilter() {
        
        
        parent::beforeFilter();
        $user=$this->user=$this->Auth->user();
        $this->loadModel('User');
        $group=$this->User->Group;
        $group->id=$user['Group']['id'];
        $this->group=$group;
        
 
    }
    
    
    public function index() {
        $notifications=$this->HK->notifications($this->Auth->user('id'));
        $messages=$this->HK->messages($this->Auth->user('id'));

        // load message statics when it is allowed.
        if($this->Acl->check($this->group,'Request','delete')){
            $this->public_messages();
        }
        
        $this->loadModel('Artist');
        $this->Artist->recursive = 0;
        $artists = $this->Artist->find('all',array(
            'fields' => array('Artist.unique','Artist.name','Artist.created','User.name','User.unique'),
            'conditions' => array('Artist.available' => 'no', 'Artist.deleted' => 'no'),
            'order' => 'Artist.id DESC',
            'limit' => 100,
        ));
        
        $this->loadModel('Album');
        $this->Album->recursive = 0;
        $albums = $this->Album->find('all',array(
            'fields' => array('Album.unique','Album.title','Album.year','Album.created','Artist.name','User.name','User.unique'),
            'conditions' => array('Album.available' => 'no', 'Album.deleted' => 'no'),
            'order' => 'Album.id DESC',
            'limit' => 100,
        ));
        
        $this->loadModel('Lyric');
        $lyrics = $this->Lyric->find('all',array(
            'fields' => array('Lyric.unique','Lyric.title','Lyric.created','Artist.name','Album.title','Album.year','User.unique','User.name'),
            'conditions' => array('Lyric.available' => 'no', 'Lyric.deleted' => 'no'),
            'order' => 'Lyric.id DESC',
            'limit' => 100,
        ));       
        
        
        $this->set('artists',$artists);
        $this->set('albums',$albums);
        $this->set('lyrics',$lyrics);
        
        $this->set('notifications',$notifications);
        $this->set('messages',$messages);
        
        $this->set('title',__('Dashboard'));
    }

    
    private function public_messages(){
        
        $this->loadModel('Messages');
        $_all = $this->Messages->find('count', array('conditions' => array('Messages.user_1' => 0)));
        $_unread = $this->Messages->find('count', array('conditions' => array('Messages.seen' => 'no', 'Messages.user_1' => 0)));
        $publicMessages['all'] = $_all;
        $publicMessages['unread'] = $_unread;
        $this->set('publicMessages',$publicMessages);
    }
    public function messages(){
        
        $this->loadModel('Message');
        $this->Paginator->settings['limit']=10;
        $this->Paginator->settings['order']='Message.created DESC';
        $this->Message->recursive = 0;
        $optionArray=array(
            
            'conditions' => array('Message.user_2' => 0),
            'order' => 'Message.created ASC','limit' => '10',
            
        ); 
        $this->Message->settings=$optionArray;
        $messages = $this->Paginator->paginate('Message');
        
        // select returned messages ids for seen manipulation.
        $returneId = array();
        foreach ($messages as $message) {
            $returneId[] = $message['Message']['id'];
        }
        $this->Message->updateAll(
            array("Message.seen" => "'yes'"),
            array('Message.id' => $returneId)
        );

        $this->public_messages();
        $this->set('title',__('Public messages'));
        $this->set('messages', $messages);
        
    }
  
}
