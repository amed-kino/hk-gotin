<?php
$uri = array(
                            'artist' => $lyric['Artist']['name'],
                            'album'  => $lyric['Album']['title'],
                            'year'   => $lyric['Album']['year'],
                            'title'  => $lyric['Lyric']['title'],
                        );

                        $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
?>

 <?php echo __('Artist');?> : <?php echo $lyric['Artist']['name'];?> 
 <?php echo __('Album');?>    : <?php echo $lyric['Album']['title'];?> <?php echo $this->HK->albumYear($lyric['Album']['year']);?>
  
 <?php if (isset($lyric['Lyric']['writer']) && $lyric['Lyric']['writer'] != ''){ echo __('Writer');?>   : <?php echo $lyric['Lyric']['writer'];}?> 
 <?php if (isset($lyric['Lyric']['composer']) && $lyric['Lyric']['composer'] != ''){ echo __('Composer');?> : <?php echo $lyric['Lyric']['composer'];}?> 
 <?php if (isset($lyric['Lyric']['echelon'])){ echo __('Echelon');?>    : <?php echo $lyric['Lyric']['echelon'];}?> 

.................................................................................


<?php echo $lyric['Lyric']['title'];?> 

<?php
$outputText = html_entity_decode($lyric['Lyric']['text'],ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
echo $outputText;
?> 


.................................................................................


<?php echo __('written by'),': ',$lyric['User']['name'],' ',$this->Time->format('d-m-Y',$lyric['Lyric']['created'],null);?> 
<?php
if (isset($lyric['Lyric']['modified']) && $lyric['Lyric']['modified'] != '0000-00-00 00:00:00'){
    echo __('last modified was at'),': ',
            $this->Time->format(
                                'd-m-Y',
                                $lyric['Lyric']['modified'],
                                null
                                );
}
?>

<?php
if (isset($lyric['Lyric']['source']) && $lyric['Lyric']['source'] != ''){
    echo __('The source of this is from : %s',$lyric['Lyric']['source']);
}

?> 

<?php echo __('link');?> : <?php echo $url;?>


[www.HuneraKurdi.com] 




