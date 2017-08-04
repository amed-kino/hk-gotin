<?php
$uri = array(
                            'artist' => $lyric['Artist']['name'],
                            'album'  => $lyric['Album']['title'],
                            'year'   => $lyric['Album']['year'],
                            'title'  => $lyric['Lyric']['title'],
                        );
                $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
                $_url = $this->Html->link($url);
header("Content-type: application/msword");

App::import('Vendor','phprtflite',array('file'=>'phprtf'.DS.'PHPRtfLite.php'));
PHPRtfLite::registerAutoloader();
$rtf = new PHPRtfLite();
$sect = $rtf->addSection();
$sect->writeText(__('Artist').": <strong>".$lyric['Artist']['name'].'</strong>', new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
$sect->writeText(__('Album').": <strong>".$lyric['Album']['title'].$this->HK->albumYear($lyric['Album']['year']).'</strong>', new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
$sect->writeText('.', new PHPRtfLite_Font(3), new PHPRtfLite_ParFormat('left'));
if (isset($lyric['Lyric']['writer']) && $lyric['Lyric']['writer'] != ''){
    $sect->writeText('   '.__('Writer').": ".$lyric['Lyric']['writer'].'', new PHPRtfLite_Font(9), new PHPRtfLite_ParFormat('left'));
}
if (isset($lyric['Lyric']['composer']) && $lyric['Lyric']['composer'] != ''){
    $sect->writeText('   '.__('Composer').": ".$lyric['Lyric']['composer'].'', new PHPRtfLite_Font(9), new PHPRtfLite_ParFormat('left'));
}
$sect->writeText('   '.__('Echelon').": ".$lyric['Lyric']['echelon'].'', new PHPRtfLite_Font(9), new PHPRtfLite_ParFormat('left'));
$sect->writeText('.', new PHPRtfLite_Font(3), new PHPRtfLite_ParFormat('left'));
$sect->writeText(' ', new PHPRtfLite_Font(9), new PHPRtfLite_ParFormat('left'));
$sect->writeText('<strong>'.$lyric['Lyric']['title'].'</strong>', new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('left'));
$sect->writeText(h($lyric['Lyric']['text']), new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('left'));
$sect->writeText('--------------------------------', new PHPRtfLite_Font(9), new PHPRtfLite_ParFormat('left'));
$sect->writeText('.', new PHPRtfLite_Font(3), new PHPRtfLite_ParFormat('left'));
$sect->writeText(__('written by').': '.$lyric['User']['name'], new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
if (isset($lyric['Lyric']['modified']) && $lyric['Lyric']['modified'] != '0000-00-00 00:00:00'){
    $sect->writeText(__('last modified was at').': '.$this->Time->format(
                                'd-m-Y',
                                $lyric['Lyric']['modified'],
                                null
                                ), new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
}
if (isset($lyric['Lyric']['source']) && $lyric['Lyric']['source'] != ''){
    $sect->writeText(__('The source of this is from : %s',$lyric['Lyric']['source']), new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
}
$sect->writeText('.', new PHPRtfLite_Font(3), new PHPRtfLite_ParFormat('left'));

$sect->writeText(__('link').': ', new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));
$sect->writeHyperLink($url, $url);
$sect->writeText('[www.HuneraKurdi.com]', new PHPRtfLite_Font(11), new PHPRtfLite_ParFormat('left'));


$rtf->sendRtf('HelloWorld');


