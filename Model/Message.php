<?php
App::uses('AppModel', 'Model');


class Message extends AppModel {


    public $belongsTo = array(
        
        'User1' => array(
            'className' => 'User',
            'foreignKey' => 'user_1',
            'fields' => array('id','unique','name'),
        ),
        
        'User2' => array(
            'className' => 'User',
            'foreignKey' => 'user_2',
            'fields' => array('id','unique','name'),
        )
    );
    

    
    
      public $validate = array(
		
        'message' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'You cant leave the message empty.',
                'allowEmpty' => false,
                'required' => true,
                ),
            'isDuplicated' => array(
                'rule' => array('isDuplicated'),
                'message' => 'You cant resend the same message.',
                ),
            'maxLength' => array(
                    'rule' => array('maxLength',255),
                    'message' => 'You cant send more than 255 letters.',
                ),
            ),
          

          
        'user_2' => array(
                'numeric' => array(
                        'rule' => array('numeric'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
          
        'message' => array(
                'notEmpty' => array(
                        'rule' => array('notEmpty'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),

                'maxLength' => array(
                    'rule' => array('maxLength', 256),
//                    'message' => 'At maximum 256 letters',
                ),

                'minLength' => array(
                    'rule' => array('minLength', 5),
//                    'message' => 'At least 2 letters.',
                ),

            ),          
          
        'marks' => array(
                'notEmpty' => array(
                        'rule' => array('notEmpty'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),

                'maxLength' => array(
                    'rule' => array('maxLength', 256),
//                    'message' => 'At maximum 256 letters',
                ),

                'minLength' => array(
                    'rule' => array('minLength', 5),
//                    'message' => 'At least 2 letters.',
                ),

            ),          
        );
                
          

function isDuplicated($check){
    
    $user_1 = $this->data['Message']['user_1'];
    $message = $this->find('first',array(
        'conditions' => array('user_1' => $user_1),
        'order' => 'Message.id DESC',
    ));
    
    
    if ($message['Message']['message']==$check['message']){
        return FALSE;
        
    }else{
        return true;
        
    }

    
}
      
}
