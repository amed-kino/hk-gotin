<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    
    
    
    public function about() {

        $this->set('title',__('About'));


    }

    
    

    public function contact() {

        $this->set('title',__('Contact'));



    }
    
    
    public function sitemap() {

        $this->set('title',__('Sitemap'));



    }
	
}
