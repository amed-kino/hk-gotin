<?php
$config=array();


$alphabit=Configure::read('HK.KurdishAlpahbit');

$lettersArray = array();
foreach($alphabit as $letter){$lettersArray[$letter] = Router::url(array('controller'=>'artists','action'=>'index',$letter),true);}


// Home array.
    $homeArray = array(

        'link' => Router::url(array('controller' =>'artists'),true),
        'letters' => 
                // Array
                $lettersArray,

        'Artist' => '',
        'Album'  => '',
        'Lyric'  => '',
    );

// Request array.
    $requestArray = array(

        'link' => Router::url(array('controller' =>'requests','action' => 'index'),true),
        'request' => array(
                'Artist' => Router::url(array('controller'=>'requests','action'=>'artist'),true),
                'Album' => Router::url(array('controller'=>'requests','action'=>'album'),true),
                'Lyric' => Router::url(array('controller'=>'requests','action'=>'lyric'),true),
            ),
        'Requests Panel' => Router::url(array('controller'=>'requests','action'=>'panel'),true),
       
    );
// User array.
    
    $userArray = array(
        'link' => Router::url(array('controller' =>'users','action' => 'index'),true),
    );

// About array.
    $aboutArray = array(
        'link' => Router::url(array('controller' =>'pages','action' => 'about'),true),
    );
    
// Contact array.
    $contactArray = array(
        'link' => Router::url(array('controller' =>'pages','action' => 'contact'),true),
    );
Configure::write('HK.sitemap.Home',$homeArray);
Configure::write('HK.sitemap.Request',$requestArray);
Configure::write('HK.sitemap.User',$userArray);
Configure::write('HK.sitemap.About',$aboutArray);
Configure::write('HK.sitemap.Contact',$contactArray);

