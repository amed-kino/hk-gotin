<?php
App::uses('AppController', 'Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class HKComponent extends Component  {


     public function letter($artist){
         $letter=mb_substr($artist,0,1,'utf-8');
         
         return $letter;
     }  



/**
 * Register notifictaions to db.
 * @param $from int user_id that make the note.
 * @param $to int user_id for person who made the note for.
 * @param $noteId int notification id (see Config[HK.Notifications]).
 * @return bool.
 */

function notificate($from,$to,$noteId,$marks){
    
    $this->Notification = ClassRegistry::init('Notification');

    $dataArray=array(
                    'id'=>null,
                    'user_1' => $from,
                    'user_2' => $to,
                    'note_id' => $noteId,
                    'marks' => $this->marks($marks),
            );
    
    if ($this->Notification->save($dataArray)){return true;}else{return false;}
}    



/**
 * Register message to db.
 * @param $from int user_id that send the message.
 * @param $to int user_id for person who been messaged.
 * @param $message string the message.).
 * @return void.
 */

function tell($from,$to,$message){
    
    if (!isset($from) || !isset($from) || !isset($from)){return false;}
    if($from==$to){return false;}
    
    $this->Message = ClassRegistry::init('Message');

    $dataArray=array(
                    'id'=>null,
                    'user_1'=>$from,
                    'user_2'=>$to,
                    'message'=>$message,
    );
    
    if ($this->Message->save($dataArray)){return true;}else{return false;}
}    
    




    
/**
 * create DB relate-field to manage associations with deferent types of data.
 * @param $type string type of association field.
 * @param $id int type id of association field.
 * @return string or null;
 */

    function related($type,$id){

        if ($type==null){return null;}
        
        $related = null;
        
        if ($type=='artist'){
            $related= 'artist'.':'.$id.',';
        }
        if ($type=='album'){
            $related= 'album'.':'.$id.',';
        }
        if ($type=='lyric'){
            $related= 'lyric'.':'.$id.',';
        }
        
        return $related;
    
        
        
        
    }    
        
    



    /**
 * return lyric editor.
 * @param $chunk string containes users id sprated by comma ','.
 * @return array contains users group;
 */

    function editors($chunk){

        $usersIds =  explode(',',$chunk);        

        $this->User = ClassRegistry::init('User');
        $users = $this->User->find('all', array(
            'conditions' =>array('User.id' => $usersIds),
            'fields' => array('User.id', 'User.unique', 'User.name'),
        ));
        

        if (!empty($users)){
            
            return $users;
         
        }else{
            return null;
        }
        
    }    
        
    
/**
 * create marks for notifications and messages that are related to entries.
 * @param $marksArray Array of marks contain each mark as key and it's value as a value.
 * @return string or null;
 */

    function marks($marksArray){
        
        if (empty($marksArray)){return null;}

        $marks = null;
        
        
        foreach ($marksArray as $key => $value) {
            
            $marks .= $key.':'.$value.',';
            
        }
        
        return $marks;
    
    }    
        
    
    
    
    
/**
 * Search for statics for the home page (statics are number of lyrics, albums and artists).
 * @return array of numbers;
 */

    function Statics(){
        
        $this->Artist = ClassRegistry::init('Artist');
        $this->Album = ClassRegistry::init('Album');
        $this->Lyric = ClassRegistry::init('Lyric');
        
        $statics['Artist'] = $this->Artist->find('count');
        $statics['Album'] =  $this->Album->find('count');
        $statics['Lyric'] =  $this->Lyric->find('count');
        return $statics;
    
    }    
        
    
    
    
    
/**
 * Chech if the id is in the chain.
 * @param $editorId id of user that want to be checked.
 * @param $editors chain of ids that want to be check in.
 * @return true,false if it is exists;
 */

    function inChain($editorId = null, $editors = null){
        
      if ($editorId == null || $editors == null){return false;} 
      
      $editorsArray=  explode($editors,',');
    
    }    
        
    
    
    
    
    
/**
 * extract notifictaions as an array.
 * @param $user_2 int user_id for person who made the note for.
 * @param $type type of notifications that want to be shown (read,unread,all).
 * @param $user_1 int user_id that make the note.
 * @return array that contains all related notifications.
 */

    function notifications($user_2,$type=null,$user_1=null){

        
        
        
        $this->Notification = ClassRegistry::init('Notification');
        
        $conditions=array();
        $optionsArray=array();
        
        
        
        $conditions['Notification.user_2']= $user_2;
        
        if(isset($user_1)){
             $conditions['Notification.user_1']= $user_1;
        }
        
        switch ($type) {
            
                   case 'read':
                       $conditions['Notification.seen']= 'yes';
                       break;
                   case 'unread':
                       $conditions['Notification.seen']= 'no';

                       break;
                   default:

                       break;
            
                }

        $optionsArray['limit']= 15;
        $optionsArray['order']= 'Notification.created DESC';
        
        $optionsArray['conditions']=$conditions;
        
        
        $notesArray=$this->Notification->find('all',$optionsArray);
        return $notesArray;
        
    }  

    
    
    
/**
 * extract notifictaions as an array.
 * @param $user_2 int user_id for person who made the note for.
 * @param $type type of notifications that want to be shown (read,unread,all).
 * @param $user_1 int user_id that make the note.
 * @return array that contains all related notifications.
 */

    function messages($user_2,$type=null,$user_1=null){
        
        if (!isset($user_2)){return false;}
        
        $this->Message = ClassRegistry::init('Message');
        
        $conditions=array();
        $optionsArray=array();
        
        $conditions['Message.user_2']= $user_2;
       
        
        if(isset($user_1)){
//             $conditions['Message.user_1']= $user_1;
        }
        
        
        switch ($type) {
            case 'read':
                $conditions['Message.seen']= 'yes';
                break;
            case 'unread':
                $conditions['Message.seen']= 'no';
                
                break;
            default:
                
                break;
        }
        
        $optionsArray['conditions']=$conditions;
        $optionsArray['limit'] = 15;
        $optionsArray['order'] = array('Message.created' => 'DESC');
//        $optionsArray['group'] = 'Message.user_1';

        
        $notesArray=$this->Message->find('all',$optionsArray);
        return $notesArray;
        
    }  
    
    
    
    
/**
 * Check if it is real unique id.
 * @param $string the unique id that want to be checked.
 * @return TRUE if its real unique id.
 * @return FALSE if its fake unique id.
 */
function uniqueCheck($string){$tiplen=strlen($string);

if ($tiplen==9){
    
    $uniuqeAlphabet=Configure::read('HK.uniuqeAlphabet');
    
    $tip_extracted = str_split($string);
    $condition=TRUE;
    foreach ($tip_extracted as $value) {
        
            if (!in_array($value,$uniuqeAlphabet)){

                $condition=FALSE;

            }
        
        }
        
            }else{return FALSE;}
            
            
        if ($condition==TRUE){return TRUE;}else{return FALSE;}
}


/**
 * Check if it is real unique id.
 * @param $content the unique id that want to be checked.
 * @return TRUE if its real unique id.
 * @return $content cleared from multilines.
 */

function fullTitleWriting($artist = null, $album = null ,$year = null){
    
    $arr = array(
        
                'Tek',
                'Cihê',
                'Tenê',
                'Single',
        
            );
    
    if (in_array($album, $arr, true)){
        $returnment = $artist . ' ' . $year;
    }else{
        $returnment = ' ' . $artist . ' - ' . $album. ' (' . $year . ') ';
    }
    
    return $returnment;
}
function textSanitize($content) {
    
  // leading white space
  $content = preg_replace('!^\s+!m', '', $content);

  // trailing white space
  $content = preg_replace('![ \t]+$!m', '', $content);

  // tabs and multiple white space
  $content = preg_replace('![ \t]+!', ' ', $content);  

  // multiple newlines
  $content = preg_replace('![\r\n]+!', PHP_EOL, $content);

  // paragraphs
  $content = preg_replace('!(.+)!m', '$1', $content);

//  return substr(trim($content), 0, -5);
  return $content;

}





/**
 * Slice the whole string to letters in an array.
 * @param $str the string that want to be Sliced.
 * @return array that contain each letter in an array [include white spaces].
 */
function sliceString($str) {
    
    if (empty($str)) return false;
    $len = mb_strlen($str);
    $array = array();
    for ($i = 0; $i < $len; $i++) {$array[] = mb_substr($str, $i, 1);
        }
    return $array;
    }


 /**
 * Clear what ever returns from both sides of the string[white spaces by default].<br>
 * Depends on sliceString();
 * @param $string the string that want to be cleared.
 * @param $rem the target string that want to be removed [white spaces by defult].
 * @return string that cleaned from both sides.
 */
function clearSpaces($string, $rem = ' ') {if (empty($string)) return false;
    // convert to array
    $arr =$this->sliceString($string);
    $len = count($arr);
    // left side
    for ($i = 0; $i < $len; $i++) {if ($arr[$i] === $rem) $arr[$i] = '';
        else break;
        }
    // right side
    for ($i = $len-1; $i >= 0; $i--) {if ($arr[$i] === $rem) $arr[$i] = '';
        else break;
        }
    // convert to string
    return implode ('', $arr);
}


/**
 * Smallize all letters in the sentence.
 * @param $string the string that want to be smallized.
 * @return string that smallized [including : ç,ş,û,î,ê].
 */
function smallizeLetter($string){
    
    $string=mb_strtolower($string);

  return $string;
  
}

public function midKurdishAlphabit($str){
    
    $arrayFromTo = array(
        
                "." => ".",
                "?" => "؟",
                "!" => "!",
                " " => " ",
                "\n" => "\n",
                PHP_EOL."a" => PHP_EOL."آ",
                PHP_EOL."A" => PHP_EOL."آ",
                " a" => " آ",
                " A" => " آ",
                "a" => "ا",
                "a" => "ا",
                "b" => "ب",
                "c" => "ج",
                "Ç" => "چ",
                "ç" => "چ",
                "d" => "د",
                " 'e" => " ع",
                "'e" => "ع",
                PHP_EOL."e" => PHP_EOL."ئە",
                " e" => " ئە",
                "e" => "ە",
                PHP_EOL."ê" => PHP_EOL."ئێ",
                " ê" => " ئێ",
                "ê" => "ێ",
                "Ê" => "ێ",
                "f" => "ف",
                "g" => "گ",
                "h" => "ه",
                "îi" => "یع",
                "i" => "",
                PHP_EOL."î" => PHP_EOL."ئی",
                PHP_EOL."Î" => PHP_EOL."ئی",
                " î" => " ئی",
                " Î" => " ئی",
                
                "î" => "ی",
                "Î" => "ی",
                "j" => "ژ",
                "k" => "ک",
                "ll" => "ڵ",
                "l" => "ل",
                "m" => "م",
                "n" => "ن",
                "o" => "ۆ",
                "p" => "پ",
                "q" => "ق",
                "r" => "ر",
                "s" => "س",
                "ş" => "ش",
                "Ş" => "ش",
                "tt" => "ت",
                "t" => "ت",
                "u" => "و",
                "û" => "وو",
                "Û" => "وو",
                "v" => "ڤ",
                "w" => "و",
                "x" => "خ",
                "y" => "ی",
                "z" => "ز",
                  
    );
    
    $str_c = str_ireplace(array_keys($arrayFromTo), $arrayFromTo, $str);
    return $str_c;
}

/**
 * Capitalize first letter of each word in the sentence.<br>depends on:<br> - smallizeLetter()<br> - clearSpaces()
 * @param $string the string that want to be capitalized.
 * @return string that the first letters are Capitalized [including : ç,ş,û,î,ê] except the $uncapitalized list.
 */
function capitalizeLetter($string){$uncapitalized=Configure::read('HK.uncapitalizedWords');
    $whole_str='';
    $string=$this->clearSpaces($string);
    $exploded=explode(" ", $string);
    $i_cap=1;
    
    foreach ($exploded as $words){$len=strlen($words);
        $fletter=mb_substr($words,0,1,'UTF-8');

        global $Title_uncapitalized;
            if (!in_array($words,$uncapitalized) || $i_cap==1){if($fletter=='Ç' or $fletter=='ç'){$fletter='Ç';
                }elseif ($fletter=='Ê' or $fletter=='ê') {$fletter='Ê';
                }elseif($fletter=='Î' or $fletter=='î'){$fletter='Î';
                }elseif ($fletter=='Ş' or $fletter=='ş'){$fletter='Ş';
                }elseif ($fletter=='Û' or $fletter=='û'){$fletter='Û';
                }else{$fletter=strtoupper($fletter);
                }
            }
        $con=mb_substr($words,1,$len,'UTF-8');
        $whole_str.=$fletter.$this->smallizeLetter($con).' ';
        $i_cap++;
    }
  
  $whole=trim(str_replace('  ', ' ', $whole_str));
  return $whole;
  
}


function letterCheck($letter){$tiplen=strlen($letter);
if ($tiplen<=2 && $tiplen!=0){$Kurdish_alphabet_extended=$uncapitalized=Configure::read('HK.KurdishAlphabetExtended');
    if (!in_array($letter,$Kurdish_alphabet_extended)){return false;
    }else {return true;}

}else{return false;
}

}

public function replaceSpecial($str){

    
    $s=array('S^','s^','SH','sh','Sh','sH','ß','β','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ș','ș','ʂ','ȿ','ᶊ','Ṡ','ṡ','Ṣ','ṣ','Ṥ','ṥ','Ṧ','ṧ','Ṩ','ṩ','$','§');
    $u=array('uu','UU','uU','Uu','U^','u^','Ù','ù','Ú','ú','Ü','ü','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ȕ','ȕ','Ȗ','ȗ','Ṹ','ṹ','Ṻ','ṻ','Ủ','ủ','Ứ','ứ','Ừ','ừ','Ử','ử','Ữ','ὐ','ὑ','ὒ','ὓ','ὔ','ὕ','ὖ','ὗ');
    $i=array('ii','II','iI','Ii','I^','i^','Ì','ì','í','Í','Ï','ï','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Ǐ','ǐ','Ȉ','ȉ','Ȋ','ȋ','Ї','ї','Ḯ','ḯ','Ỉ','ỉ');
    $e=array('E^','e^','È','è','É','é','Ë','ë','Ē','ē','Ĕ','ĕ','Ė','ė','Ě','ě','Ӗ','ӗ','Ḕ','ḕ','Ḗ','ḗ','Ẻ','ẻ','Ẽ','ẽ','Ế','ế','Ề','ề','Ể','ể','Ễ','ễ','Ệ','ệ');
    $c=array('C^','c^','CH','ch','Ch','cH','Ҫ','ҫ','Ć','ć','Ċ','ċ','Č','č','Ĉ','ĉ','Ḉ','ḉ');
	
    $str=str_ireplace($s,'ş', $str);
    $str=str_ireplace($u,'û', $str);
    $str=str_ireplace($i,'î', $str);
    $str=str_ireplace($e,'ê', $str);
    $str=str_ireplace($c,'ç', $str);

    $str=  mb_strtolower($str,'utf-8');
    $str=  trim(preg_replace('/\s+/', ' ',$str));
    
    return $str;
    
}

public function replaceChr($str){

    
    $s=array('S^','s^','SH','sh','Sh','sH','ß','β','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ș','ș','ʂ','ȿ','ᶊ','Ṡ','ṡ','Ṣ','ṣ','Ṥ','ṥ','Ṧ','ṧ','Ṩ','ṩ','$','§');
    $u=array('uu','UU','uU','Uu','U^','u^','Ù','ù','Ú','ú','Ü','ü','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ȕ','ȕ','Ȗ','ȗ','Ṹ','ṹ','Ṻ','ṻ','Ủ','ủ','Ứ','ứ','Ừ','ừ','Ử','ử','Ữ','ὐ','ὑ','ὒ','ὓ','ὔ','ὕ','ὖ','ὗ');
    $i=array('ii','II','iI','Ii','I^','i^','Ì','ì','í','Í','Ï','ï','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Ǐ','ǐ','Ȉ','ȉ','Ȋ','ȋ','Ї','ї','Ḯ','ḯ','Ỉ','ỉ');
    $e=array('ee','EE','Ee','eE','E^','e^','È','è','É','é','Ë','ë','Ē','ē','Ĕ','ĕ','Ė','ė','Ě','ě','Ӗ','ӗ','Ḕ','ḕ','Ḗ','ḗ','Ẻ','ẻ','Ẽ','ẽ','Ế','ế','Ề','ề','Ể','ể','Ễ','ễ','Ệ','ệ');
    $c=array('C^','c^','CH','ch','Ch','cH','Ҫ','ҫ','Ć','ć','Ċ','ċ','Č','č','Ĉ','ĉ','Ḉ','ḉ');
	
    $str=str_ireplace($s,'ş', $str);
    $str=str_ireplace($u,'û', $str);
    $str=str_ireplace($i,'î', $str);
    $str=str_ireplace($e,'ê', $str);
    $str=str_ireplace($c,'ç', $str);

  
    return $str;
    
}



public function isKurdish($check){
    $_alphabit=Configure::read('HK.KurdishAlphabetExtended');
    $_nubmers=array('0','1','2','3','4','5','6','7','8','9',' ');
    $alphabit=  array_merge($_alphabit,$_nubmers);
    
    $return_string = preg_replace('/\s+/', ' ',$check);
    
    $stringArray=preg_split('/(?<!^)(?!$)/u', $return_string);
    
    
    $condition=true;
    foreach ($stringArray as $index=> $letter) {    
        if (!in_array($letter, $alphabit)){
            $condition=false;
            break;
        }
    }
    if ($condition==true){return TRUE;}else{return FALSE;}

 }          

 
 
 
 
 public function upload($file,$name,&$filePointer){
  
     if ($file == null){return false;}
        $max_file = 2;
        
        $allowed_image_types = array(
            
            'image/pjpeg'=>"jpg",
            
            'image/jpeg'=>"jpeg",
            
            'image/jpeg'=>"jpg",
            
            'image/jpg'=>"jpg",
            
            'image/png'=>"png",
            
            'image/x-png'=>"png",
            
            'image/gif'=>"gif"
            
        );
      
        $max_width = "520";
        
$large_image_location = WWW_ROOT .'demki'.DS;
$thumb_image_location = WWW_ROOT .'demki'.DS ;


        
	//Get the file information
	$userfile_name = $_FILES['file']['name'];
	$userfile_tmp = $_FILES['file']['tmp_name'];
	$userfile_size = $_FILES['file']['size'];
	$userfile_type = $_FILES['file']['type'];
	$filename = basename($_FILES['file']['name']);
	$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        
	//Only process if the file is a JPG, PNG or GIF and below the allowed limit
	if((!empty($_FILES["file"])) && ($_FILES['file']['error'] == 0)) {
		
		foreach ($allowed_image_types as $mime_type => $ext) {
			//loop through the specified image types and if they match the extension then break out
			//everything is ok so go and check file size
			if($userfile_type==$mime_type){
				$error = "";
				break;
			}else{
				$error = "Only images accepted for upload ";
			}
		}
		//check if the file size is above the allowed limit
		if ($userfile_size > ($max_file*1048576)) {
			$error.= "Images must be under MB in size";
		}
		
	}else{
		return false;
	}
	//Everything is ok, so we can upload the image.
       
	if (strlen($error)==0){
            
		if (isset($_FILES['file']['name'])){
                    
			//this file could now has an unknown file extension (we hope it's one of the ones set above!)
			$large_image_location = $large_image_location.$name.'.'.$file_ext;
			$thumb_image_location = $thumb_image_location.$name.'_2.'.$file_ext;
			
			//put the file ext in the session so we know what file to look for once its uploaded
		
			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);
			
			$width = $this->getWidth($large_image_location);
			$height = $this->getHeight($large_image_location);
                       
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = $this->resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = $this->resizeImage($large_image_location,$width,$height,$scale);
			}
//			//Delete the thumbnail file so the user can create a new one
//			if (file_exists($thumb_image_location)) {
//				unlink($thumb_image_location);
//			}
                        $filePointer = $large_image_location;
                        return true;
		}
                
		
        }else{
            return false;
        }
}
    
    function resizeImage($image,$width,$height,$scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$image); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$image,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$image);  
			break;
    }
	
	chmod($image, 0777);
	return $image;
    }

    function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
        
            list($imagewidth, $imageheight, $imageType) = getimagesize($image);
            $imageType = image_type_to_mime_type($imageType);

            $newImageWidth = ceil($width * $scale);
            $newImageHeight = ceil($height * $scale);
            $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
            switch($imageType) {
                    case "image/gif":
                            $source=imagecreatefromgif($image); 
                            break;
                case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            $source=imagecreatefromjpeg($image); 
                            break;
                case "image/png":
                    case "image/x-png":
                            $source=imagecreatefrompng($image); 
                            break;
            }
            imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
            switch($imageType) {
                    case "image/gif":
                            imagegif($newImage,$thumb_image_name); 
                            break;
            case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                            imagejpeg($newImage,$thumb_image_name,90); 
                            break;
                    case "image/png":
                    case "image/x-png":
                            imagepng($newImage,$thumb_image_name);  
                            break;
        }
            chmod($thumb_image_name, 0777);
            return true;
    }
    
    function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
    }

    function getWidth($image) {
            $size = getimagesize($image);
            $width = $size[0];
            return $width;
    }
    
    public function setFileName($fileName, $separator = '_', $defaultIfEmpty = 'default', $lowerCase = true){


    // Gather file informations and store its extension
                $fileInfos = pathinfo($fileName);
                $fileExt   = array_key_exists('extension', $fileInfos) ? '.'. strtolower($fileInfos['extension']) : '';
                // Removes accents
				$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
				$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
				$fileName = str_replace($a, $b, $fileInfos['filename']);
                //$fileName = @iconv('UTF-8', 'us-ascii//TRANSLIT', $fileInfos['filename']);
                //setlocale(LC_COLLATE, 'en_US.utf8');
				//$fileName = @iconv('UTF-8', 'us-ascii//TRANSLIT', $fileInfos['filename']);

                // Removes all characters that are not separators, letters, numbers, dots or whitespaces
                $fileName = preg_replace("/[^ a-zA-Z". preg_quote($separator). "\d\.\s]/", '', $lowerCase ? strtolower($fileName) : $fileName);
                // Replaces all successive separators into a single one
                $fileName = preg_replace('!['. preg_quote($separator).'\s]+!u', $separator, $fileName);
                // Trim beginning and ending seperators
                $fileName = trim($fileName, $separator);
                // If empty use the default string
                if (empty($fileName)) {$fileName = $defaultIfEmpty;
                }
                return $fileName. $fileExt;
        }
        
    // Suspended Function
    // :-(    
    public function createThumbnails($image, $dir){
        $file = $dir.$image;
        
        
        if (!file_exists($file)){
            return FALSE;
        }
        
        // Create 180x180 mzn thumbnail
        $this->resizeThumbnailImage($dir.'mzn_'.$image, $file, 200, 200,0, 0, 0.9);
        // Create 120x120 tun thumbnail
        $this->resizeThumbnailImage($dir.'tun_'.$image, $file, 200, 200,0, 0, 0.6);
        // Create 80x80 cuk thumbnail
        $this->resizeThumbnailImage($dir.'cuk_'.$image, $file, 200, 200,0, 0, 0.4);
        
        return true;
        
    }
 
   
    /* Decode the uri to pure text
     * $type ['album','year']
     */
    public function uriDecoder($data = null, $type = null){
        
        if ($data == null || $data == ''){
            return false;
        }
        
        // album section
        if ($type == 'album'){
            
            $uri = substr(str_replace('-', ' ', mb_strtolower($data)), 0, -5);
            
        }else if($type=='year'){
            
            $uri = substr(str_replace('-', ' ', mb_strtolower($data)), -4, 4);
        }else{
            
            $uri = str_replace('-', ' ', mb_strtolower($data));
        }
        
        
        if ($this->isKurdish($uri)){
            return $uri;
        }else{
            return false;
        }
        
    }
    
   public function encodeURI($url) {
  
    $unescaped = array(
        '%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',
        '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
    );
    $reserved = array(
        '%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',
        '%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'
    );
    $score = array(
        '%23'=>'#'
    );
    return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));

}
    public function fileExisted($file = null, $type = null){
        
        
        if (!isset($file)){return false;}
        
        
        if (strstr($file, 'http') == false){
            
            $file = FULL_BASE_URL . '/' . 'stran' . '/' . $this->encodeURI($file);
        }
        $file_headers = @get_headers($file,1);
        
        if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        }else {
            $exists = true;
        }
        
        if ($type == null){
            return $exists;
        }else{
            if ($type == 'mp3'){
//                if ($file_headers['Content-Type'] == 'audio/mpeg' || $file_headers['Content-Type'] == 'audio/x-ms-wma']){
                if ($file_headers['Content-Type'] == 'audio/mpeg'){
                    return true;
                }else{
                    return false;
                }
            }
            
        }
    }
}
