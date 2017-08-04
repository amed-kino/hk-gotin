<?php

App::uses('AppController', 'Controller');
App::uses('HKComponent', 'Component');
/**
 * Requests Controller
 *
 * @property Request $Request
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RequestsController extends AppController {/**
 * Components
 *
 * @var array
 */
	
    
    public $components = array('Paginator');
    public $helpers = array('Paginator');
        
          
    private $user;
    private $group;
    
    
    public function beforeFilter() {
        
        parent::beforeFilter();
        
        $this->Auth->allow('artist','album','lyric','index','panel');
        
        if($this->Session->check('Auth.User')){
            $user=$this->user=$this->Auth->user();
            $this->loadModel('User');
            $group=$this->User->Group;
            $group->id=$user['Group']['id'];
            $this->group=$group;
        }
        
    }


    public function index() {
        $this->set('title',__('Request'));
    
        $this->Request->recursive = 0;
        $requests=$this->Request->find('all',array(
            
                'conditions' => array('Request.public' => 'yes'),
                'order' => 'Request.created DESC',
                'limit' => '5',
            
        ));
        $this->set('requests',$requests);
    }

    

	public function delete($id = null) {
            if (!$this->Acl->check($this->group,'Lyric','delete')){throw new NotFoundException(__('Invalid request'));}
		$this->Request->id = $id;
		if (!$this->Request->exists()) {
			throw new NotFoundException(__('Invalid request'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Request->delete()) {
                        $this->Session->setFlash(
                            __('The request has been deleted.'), //Message
                            'flash',                   //Element 
                            array(
                                'title' => __('Delete status'),
                                'position'=>'left',
                                'type'=>'danger'
                                )
                        );
		} else {
                        $this->Session->setFlash(
                            __('The request can not be deleted.'), //Message
                            'flash',                   //Element 
                            array(
                                'title' => __('Delete status'),
                                'position'=>'left',
                                'type'=>'error'
                                )
                        );
		}
		return $this->redirect(array('action' => 'panel'));
	}
    
    public function panel() {
        
        $this->Paginator->settings['limit']=10;
        $this->set('title',__('Requests Panel'));
    
        if ($this->Auth->user()){
            
            $optionArray=array(
                'order' => 'Request.created DESC','limit' => '10',
                );  
        }else{
            
            $optionArray=array(
                'conditions' => array('Request.public' => 'yes'),
                'order' => 'Request.created DESC','limit' => '10',
                );  
        }
        $this->Request->recursive = 0;
        $this->Paginator->settings=$optionArray;
        $this->set('requests', $this->Paginator->paginate());
        
    }

    
    
    
    public function artist($data=null) {
        
        $this->set('title',__('Request an Artist'));

        if ($this->request->is('post')){
              
            $this->Request->create();
          
            $dataArray['type']    =   'artist';
            $dataArray['name']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['name']));
            $dataArray['email']   =   $this->HK->replaceSpecial(h($this->request->data['Request']['email']));
            $dataArray['data']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['data']));
            $dataArray['public']  =   $this->HK->replaceSpecial(h($this->request->data['Request']['public']));
          
            if ($this->Request->save($dataArray)){
                $this->Session->setFlash(
                                __('Artist request been sent successfully.'), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('Request an Artist'),
                                    'position'=>'bottom',
                                    'type'=>'success'
                                    )
                                );
                
                if ($dataArray['public']=='yes'){
                    $this->redirect(array('controller'=>'requests','action'=>'panel'));
                }else{
                    $this->redirect(array('controller'=>'artists','action'=>'index'));
                }
                
            }else{
                $this->Session->setFlash(__('Error in request.'),'default',array(),'flashError');
            }
        }

    }

    public function album($data=null) {
        
        $this->set('title',__('Request an Album'));

        if ($this->request->is('post')){
              
            $this->Request->create();
          
            $dataArray['type']    =   'album';
            $dataArray['name']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['name']));
            $dataArray['email']   =   $this->HK->replaceSpecial(h($this->request->data['Request']['email']));
            $dataArray['data']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['data']));
            $dataArray['public']  =   $this->HK->replaceSpecial(h($this->request->data['Request']['public']));
          
            if ($this->Request->save($dataArray)){
                $this->Session->setFlash(
                                __('Album request been sent successfully.'), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('Request an Album'),
                                    'position'=>'bottom',
                                    'type'=>'success'
                                    )
                                );
                
                if ($dataArray['public']=='yes'){
                    $this->redirect(array('controller'=>'requests','action'=>'panel'));
                }else{
                    $this->redirect(array('controller'=>'artists','action'=>'index'));
                }
                
            }else{
                $this->Session->setFlash(__('Error in request.'),'default',array(),'flashError');
            }
        }

    }

    public function lyric($data=null) {
        
        $this->set('title',__('Request a Lyric'));

        if ($this->request->is('post')){
              
            $this->Request->create();
          
            $dataArray['type']    =   'lyric';
            $dataArray['name']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['name']));
            $dataArray['email']   =   $this->HK->replaceSpecial(h($this->request->data['Request']['email']));
            $dataArray['data']    =   $this->HK->replaceSpecial(h($this->request->data['Request']['data']));
            $dataArray['public']  =   $this->HK->replaceSpecial(h($this->request->data['Request']['public']));
          
            if ($this->Request->save($dataArray)){
                $this->Session->setFlash(
                                __('Lyric request been sent successfully.'), //Message
                                'flash',                   //Element 
                                array(
                                    'title' => __('Request a Lyric'),
                                    'position'=>'bottom',
                                    'type'=>'success'
                                    )
                                );
                
                if ($dataArray['public']=='yes'){
                    $this->redirect(array('controller'=>'requests','action'=>'panel'));
                }else{
                    $this->redirect(array('controller'=>'artists','action'=>'index'));
                }
                
            }else{
                $this->Session->setFlash(__('Error in request.'),'default',array(),'flashError');
            }
        }

    }

}
