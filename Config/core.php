<?php
  Configure::write('debug', 0);
  Configure::write('Error', array('handler' => 'ErrorHandler::handleError','level' => E_ALL & ~E_DEPRECATED,'trace' => true));
	Configure::write('Exception', array('handler' => 'ErrorHandler::handleException','renderer' => 'ExceptionRenderer','log' => true));
	Configure::write('App.encoding', 'UTF-8');
	Configure::write('Session', array('defaults' => 'php'));
	Configure::write('Security.salt', '');
	Configure::write('Security.cipherSeed', '');
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');


$engine = 'File';
$duration = '+999 days';
if (Configure::read('debug') > 0) {$duration = '+10 seconds';}
$prefix = 'myapp_';
Cache::config('_cake_core_', array(

	'engine' => $engine,

	'prefix' => $prefix . 'cake_core_',

	'path' => CACHE . 'persistent' . DS,

	'serialize' => ($engine === 'File'),

	'duration' => $duration

));


Cache::config('_cake_model_', array(

	'engine' => $engine,

	'prefix' => $prefix . 'cake_model_',

	'path' => CACHE . 'models' . DS,

	'serialize' => ($engine === 'File'),

	'duration' => $duration

));





/**

 * Configure the HK for HKApp.

 */

$_KurdishAlphabit = array(

                        // Capital letters.

                               "A","B","C","Ç","D","E","Ê","F","G","H","I","Î","J","K","L","M","N","O","P","Q","R","S","Ş","T","U","Û","V","W","X","Y","Z"

                        );

$_KurdishAlphabetExtended = array(

                        // Capital letters.

                               "A","B","C","Ç","D","E","Ê","F","G","H","I","Î","J","K","L","M","N","O","P","Q","R","S","Ş","T","U","Û","V","W","X","Y","Z",

                        // Small Letters.

                                "a","b","c","ç","d","e","ê","f","g","h","i","î","j","k","l","m","n","o","p","q","r","s","ş","t","u","û","v","w","x","y","z"

                        );



$_uncapitalizedWords = array(

            //neutrality words of capitalization.

                "re","jî","yan","û","di","e","ê","î","in","im","i","li","ji",
//    "of","the","from","on","at","in",

                        );



$_uniuqeAlphabet = array(

                        // Capital letters.

                               "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",

                        // Small Letters.

                               "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",

                        // Numbers

                                '0','1','2','3','4','5','6','7','8','9',

                        );



Configure::write('HK.KurdishAlpahbit',$_KurdishAlphabit);

Configure::write('HK.KurdishAlphabetExtended',$_KurdishAlphabetExtended);

Configure::write('HK.uncapitalizedWords',$_uncapitalizedWords);

Configure::write('HK.uniuqeAlphabet',$_uniuqeAlphabet);





Configure::write('Config.language','ku');





/**

 * HybridAuth component

 *

 */

 Configure::write('Hybridauth', array(

    // openid providers

    "Google" => array(

        "enabled" => false,

        "keys" => array("id" => "Your-Google-Key","secret" => "Your-Google-Secret"),

    ),

   "Twitter" => array(

       "enabled" => false,

       "keys" => array("key" => "_", "secret" => "_")

   ),

    "Facebook" => array(

        "enabled" => true,
        // Orginal facebook app.

        "keys" => array("id" => "_", "secret" => "_"),

    ),

    "OpenID" => array(

        "enabled" => false

    ),

    "Yahoo" => array(

        "enabled" => false,

        "keys" => array("id" => "", "secret" => ""),

    ),

    "AOL" => array(

        "enabled" => false

    ),

    "Live" => array(

        "enabled" => false,

        "keys" => array("id" => "", "secret" => "")

    ),

    "MySpace" => array(

        "enabled" => false,

        "keys" => array("key" => "", "secret" => "")

    ),

    "LinkedIn" => array(

        "enabled" => false,

        "keys" => array("key" => "", "secret" => "")

    ),

    "Foursquare" => array(

        "enabled" => false,

        "keys" => array("id" => "", "secret" => "")

    ),

));



 Configure::load('cdn');
