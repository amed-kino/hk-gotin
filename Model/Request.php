<?php
App::uses('AppModel', 'Model');
/**
 * Request Model
 *
 */
class Request extends AppModel {/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
		'name' => array(
                        
                                     
			'isKurdish' => array(
				'rule' => array('isKurdish'),
				'message' => 'Only Kurdish-Latin alphabet is allowed.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                    
                        'maxLength' => array(
                            'rule' => array('maxLength',64),
                            'message' => 'Maximum letters (64)',
                        ),  
                    
                    'notEmpty' => array(
                            'rule' => array('notEmpty'),
                            'message' => 'You can not leave it empty.',
                            'allowEmpty' => false,
                            'required' => true, 
                        ),        
                    
                    
                ),
            
		'email' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'You can\'t leave Email blank.',
			),
			'maxLength' => array(
				'rule' => array('maxLength',64),
				'message' => 'maximum letters been reached',
			),
		),            
		
		'data' => array(
                    
                        'maxLength' => array(
                            'rule' => array('maxLength',256),
                            'message' => 'Maximum letters (256)',
                        ),
                        'notEmpty' => array(
                            'rule' => array('notEmpty'),
                            'message' => 'You can not leave it empty.',
                            'allowEmpty' => false,
                            'required' => true, 
                        ),   
                ),
		'public' => array(
                   
                        'notEmpty' => array(
                            'rule' => array('notEmpty'),
                            'message' => 'You can not leave it empty.',
                            'allowEmpty' => false,
                            'required' => true, 
                        ),   
                ),            
	);
        
public function isKurdish($_check){
    
    $_alphabit=Configure::read('HK.KurdishAlphabetExtended');
    $_nubmers=array('0','1','2','3','4','5','6','7','8','9',' ');
    $alphabit=  array_merge($_alphabit,$_nubmers);
    foreach ($_check as $check)
    $return_string = preg_replace('/\s+/', ' ',$check);
    
    $stringArray=preg_split('/(?<!^)(?!$)/u', $return_string);
    
    
    $condition=true;
    foreach ($stringArray as $index=> $letter) {    
        if (!in_array($letter, $alphabit)){
            $condition=false;
            break;
        }
    }
    if ($condition==TRUE){return TRUE;}else{return FALSE;}

 }           
}
