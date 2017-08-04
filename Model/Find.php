<?php
App::uses('AppModel', 'Model');

class Find extends AppModel {
    
  public $hasMany=array(
      'Artist',
      'Album',
      'Lyric',
  );
   
}

