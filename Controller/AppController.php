<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    

    

    public $components = array(
        'Contacter.SideForm',
        'Session',
        'Cookie',
        'HK',
        'RequestHandler',
        'Acl',
        'Auth'  => 
                array(  'loginRedirect' => array('controller' => 'users', 'action' => 'login'), 

                        'logoutRedirect' => array( 'controller' => 'artists', 'action' => 'index' ), 

                        'authenticate' => array( 'Form' => array( 'passwordHasher' => 'Blowfish','scope' => array('User.active' => 'yes'))),

                        

                    ));

    

 function beforeRender() {
        parent::beforeRender();
        $_uriQuery = $this->request->query;
        
        if ($this->layout!='preformance' && $this->layout!='js' && $this->layout!='empty' && $this->layout!='pdf'){
            if (isset($_uriQuery['awa'])){
//                if ($_uriQuery['awa'] == '1'){
//                    $this->layout='awa1';
//                }else{
//                    $this->layout='awa2';
//                    
//                }
                
            }else{
                if ($this->layout == 'player'){
                    $this->layout='player';
                }else{
                    if ($this->Session->check('Auth.User')){
                        $this->layout='dashboard';
                    }else{
                        $this->layout='default';
                    }
                }
            }
        }

    

    }
    

    	function force() {
            
            
        $urlParams = explode('.', env('SERVER_NAME'));
		if(!$this->RequestHandler->isSSL() || $urlParams [0] == 'www') {
                        $newUrl = str_replace('www.', '', env('SERVER_NAME'));
			$this->redirect('https://'.$newUrl);
		}
	} 

	function unforce() {
		if($this->RequestHandler->isSSL()) {
			$this->redirect('http://'.$this->__url());
		}
	}

	/**This method updated from John Isaacks**/
	function __url($default_port = 80)
	{
//		$port = env('SERVER_PORT') == $default_port ? '' : ':'.env('SERVER_PORT');
		return env('SERVER_NAME');
                
	}
        

    public function beforeFilter() {

   $this->force();

//    if (!$this->Auth->loggedIn() && $this->Cookie->read('remember_me_cookie')) {

//        $cookie = $this->Cookie->read('remember_me_cookie');

//        var_dump($cookie);

//        if(isset($cookie)){ $this->loadModel('User');

//        $user = $this->User->find('first', array(

//            'conditions' => array(

//                'User.username' => $cookie['username'],

//                'User.password' => $cookie['password']

//            )

//        ));}

//       

//

//        if ($user && !$this->Auth->login($user['User'])) {

//            $this->redirect('/users/logout'); // destroy session & cookie

//        }

//    }

}



        

}

