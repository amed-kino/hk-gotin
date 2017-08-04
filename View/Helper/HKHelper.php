<?php 
class HKHelper  extends AppHelper {
    
    private $Notifications;
    var $helpers = array('Html');

  
    function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
        
        $this->Notifications=Configure::read('HK.Notifications');
         
    }
    
    public function notification($note){
        
        if (empty($note)){return null;}
        
        $id = $note['Notification']['note_id'];
        $a1 = (int)substr($id,0,1);
        $a2 = (int)substr($id,1,1);

        
        // Artsit part - when a1=1
        $noteArray[1][1]=__('%s has edited %s');
        $noteArray[1][2]=__('%s has requested to edit %s');
        $noteArray[1][3]=__('%s has deleted %s');
        $noteArray[1][4]=__('%s has requested to delete %s');
        $noteArray[1][5]=__('%s has accepted %s');
        $noteArray[1][6]=__('%s has declined %s');
        // Album part - when a1=2
        $noteArray[2][1]=__('%s has edited %s');
        $noteArray[2][2]=__('%s has requested to edit %s');
        $noteArray[2][3]=__('%s has deleted %s');
        $noteArray[2][4]=__('%s has requested to delete %s');
        $noteArray[2][5]=__('%s has accepted %s');
        $noteArray[2][6]=__('%s has declined %s');
        // Lyric part - when a1=3
        $noteArray[3][1]=__('%s has edited %s');
        $noteArray[3][2]=__('%s has requested to edit %s');
        $noteArray[3][3]=__('%s has deleted %s');
        $noteArray[3][4]=__('%s has requested to delete %s');
        $noteArray[3][5]=__('%s has accepted %s');
        $noteArray[3][6]=__('%s has declined %s');  
        
        $marks = $this->marks($note['Notification']['marks']);
        
        
        $user = $note['User1']['name'];
        
       
     
        
        
        // if the type of notification is for Artist modal
        if ($a1==1){
            
            
            $title = $marks['artistName']; 
            $icon = ' <i class="glyphicon glyphicon-artist"> </i> ';
            if ($a2==3){
                $moreLink = null;
            }else{
                $moreLink= Router::url(array('controller' =>'artists','action' => 'index',$marks['artistUnique']), true);
            }
        }
        else if ($a1==2){
            
            
            $title = $marks['artistName'].'-'.$marks['albumTitle'];
            $icon = ' <i class="glyphicon glyphicon-album"> </i> ';
            
            if ($a2==3){
                $moreLink = null;
            }else{
                $moreLink= Router::url(array('controller' =>'albums','action' => 'index',$marks['albumUnique']), true);
            }
        }
        else if ($a1==3){
            
            
            $title = $marks['artistName'].'-'.$marks['lyricTitle'];
            $icon = ' <i class="glyphicon glyphicon-lyric"> </i> ';
            
            
            if ($a2==2){
                $moreLink= Router::url(array('controller' =>'lyrics','action' => 'history',$marks['lyricUnique'],$marks['editLyricId']), true);
            }elseif($a2==3){
                $moreLink = null;
            }else{
                $moreLink = Router::url(array('controller' =>'lyrics','action' => 'index',$marks['lyricUnique']), true);
            }
        }
        else{
            
            $title = '';
            $icon = ' <i class="glyphicon glyphicon-bullhorn"> </i> ';
            $moreLink = '#';
        }
        
        $noteRaw=$noteArray[$a1][$a2];
        $noteString = vsprintf($noteRaw,array('<span class="user">'.$user.'</span>','<span class="title">'.$title.'</span>') );

        $output['moreLink'] = $moreLink;
        $output['created'] = $note['Notification']['created'];
        $output['icon'] = $icon;
        $output['text'] =
                ''
                . $noteString
                . ''  ;


        
        return $output;
    }
    
    public function rank($rank){
        return true;
    }

    public function related($related){
        
        $exploded = explode(',', $related);
        foreach ($exploded as $items){
            $item = explode(':', $items);
            if (@$item[1] != null){$dataArray[$item[0]] = $item[1];}
        }
        return $dataArray;
    }
    
    

    public function marks($marks){
        
        $exploded = explode(',', $marks);
        foreach ($exploded as $items){
            $item = explode(':', $items);
            if (@$item[1] != null){$dataArray[$item[0]] = $item[1];}
        }
        return $dataArray;
    }
  

    public function siteMapItems($siteMap,$section ){
        if (is_array($siteMap)){
            foreach ($siteMap as $key => $value) {
                if (is_array($value)){
                    echo '<li>'.$key.'</li>';
                   echo '<ul class="'.$key.'">';
                   $this->siteMapItems($value,$key);
                   echo '</ul>';
                }else{
                    if ($key != 'link'){
                        if ($value != ''){
                            if ($section == 'letters'){
                                $class = ' class="letters"';
                            }else{
                                $class = '';
                            }
                            echo '<li'.$class.'><a href="'.$value.'">'.__($key).'</a></li>';
                        }else{
                            echo '<li>'.$key.'</li>';
                        }
                    }
                }
                
            }
        }
    
    }
    
    public function menuItemCreator($linkText, $dataArray){
        
        
        $currentController = $this->params->controller;
        $currentAction= $this->params->action;
        
        $linkController = $dataArray['controller'];
        $linkAction = $dataArray['action'];
        
        // Manipulate the current tab because if many actions
        $current = false;
        if ($currentController == $linkController && $currentAction == $linkAction){
            
            $current = true;
            

        }
        if ($currentController == 'requests' && $linkController == 'requests'){
            $current = true;
        }
        if ($currentController == 'requests' && $linkController == 'requests'){
            $current = true;
        }
        
        if ($current === true){
            $inj = ' class="active"';
        }else{
            $inj='';
        }
        
//        var_dump($controller,$action);
       
        $data = '';
        $data .= '<li'.$inj.'>';
        $data .= $this->Html->link(__($linkText),$dataArray); 
        $data .= '</li>';

        return $data;
    }
    
    
     public function scissors($str, $type){
         
         
         // if the text is username 
         if ($type == 'username'){
            if (strlen($str)>10){
                $dataReturn = mb_substr($str, 0, 8).'..';
            }else{
                $dataReturn = $str;
            }
         }
         
         // if the text is message or note 
         if ($type == 'note'){
            if (strlen($str)>114){
                $dataReturn = mb_substr($str, 0, 110).'....';
            }else{
                $dataReturn = $str;
            }
         }
         if ($type == 'Lyric.title'){
            if (strlen($str)>32){
                $dataReturn = mb_substr($str, 0, 30).'..';
            }else{
                $dataReturn = $str;
            }
         }
        
        return $dataReturn;
    }
    
    
     public function urlCreator($dataArray = null){
        
        if ($dataArray ==null){
            return null;
        }
        
        return $dataArray[0];
        
    }
    
    
    public function uri($data = null){
        
        
    // Check if it is valid array
        if (!is_array($data) || empty($data)){
            return null;
        }
        
        $uri = '/';
        
    // Artist part of URI
        if (isset($data['artist'])){
            $uri .= str_replace(' ', '-', mb_strtolower($data['artist']));
        }
        
    // Album+Year part of URI
        
        // Album part
        if (isset($data['album'])){
            $uri .= '/'.str_replace(' ', '-', mb_strtolower($data['album']));
            
            // Year part
            if (isset($data['year'])){
            $uri .= '-'.str_replace(' ', '-', mb_strtolower($data['year']));
            }
            
        }
        
    // Lyric part of URI
        if (isset($data['title'])){
            $uri .= '/'.str_replace(' ', '-',mb_strtolower($data['title']));
        }
        
        $uri .= '/';
        return rawurldecode($uri);
       
    }
    
    public function albumYear($data){
        
        if ( (strlen($data) != 4) || ( (int)$data == 0000) ){
            return '';
        }else{
            return ' ('.$data.')';
        }
        
    }
    
    
}