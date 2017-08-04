<?php



$config=array();
Configure::write('HK.links.albumsList',Router::url(array('controller' =>'ajax','action' => 'albumslist'),true));
Configure::write('HK.links.addAlbum',Router::url(array('controller' =>'albums','action' => 'add'),true));
Configure::write('HK.links.changePassword',Router::url(array('controller' =>'ajax','action' => 'changepassword'),true));
Configure::write('HK.links.changeRank',Router::url(array('controller' =>'ajax','action' => 'changeRank'),true));
Configure::write('HK.links.social.facebook','https://www.facebook.com/hunerakurdi.gotin');
Configure::write('HK.links.social.twitter','https://twitter.com/HuneraKurdi');
Configure::write('HK.links.social.google','https://plus.google.com/100107148930677086043/');

