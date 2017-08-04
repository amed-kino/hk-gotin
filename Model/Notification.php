<?php
App::uses('AppModel', 'Model');


class Notification extends AppModel {

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
        ),
    );
    


}
