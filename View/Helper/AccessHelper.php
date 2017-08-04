<?php 
class AccessHelper extends AppHelper {
    
    var $Access; 
    var $Auth; 
    var $Acl; 
    var $user; 
  
    function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->Acl=$settings['Acl'];
         
    }
  
    function check($aco, $action='*'){ 
        if(empty($this->user)) return false; 
        return $this->Access->checkHelper($aco, $action); 
    } 
  
    function isLoggedin(){ 
        return !empty($this->user); 
    } 
} 
?>