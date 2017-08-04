<?php
$uri = array(
                            'artist' => $lyric['Artist']['name'],
                            'album'  => $lyric['Album']['title'],
                            'year'   => $lyric['Album']['year'],
                            'title'  => $lyric['Lyric']['title'],
                        );

                        $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $lyric['Artist']['name'];?> - <?php echo $lyric['Album']['title'];?> <?php echo $this->HK->albumYear($lyric['Album']['year']);?></title>
<style>
body{font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;font-size:16px;line-height:1.1em;}
#main-container{margin: auto;width:992px;padding-top: 60px;}
#name-album{border-bottom: 1px black dashed;margin-bottom: -9px;padding-bottom: 9px;width: 90px;overflow: visible;white-space: nowrap;}
#writer-composer{border-bottom: 1px black dashed;margin-bottom: -9px;padding-bottom: 9px;width: 290px;overflow: visible;white-space: nowrap;}
#meta{border-bottom: 1px black dashed;margin-bottom: -9px;padding-bottom: 9px;width: 290px;overflow: visible;white-space: nowrap;}
@media print, screen and (min-width:992px) and (max-width:1199px) {#main-container{width:100%;padding-top: 40px;}}
@media only screen and (min-width: 768px) and (max-width: 991px) {#main-container{width:100%;padding-top: 20px;}}
@media only screen and (max-width:767px) {#main-container{width:100%;padding-top: 20px;}}
</style>
</head>
<body>
    <div id="main-container">
        <div id="header">
            
            <div id="name-album"><?php echo $lyric['Artist']['name'];?> - <?php echo $lyric['Album']['title'];?> <?php echo $this->HK->albumYear($lyric['Album']['year']);?></div><br>
            <div id="writer-composer">
                <?php if (isset($lyric['Lyric']['writer'])){  echo __('Writer');?>   : <?php echo $lyric['Lyric']['writer'],'<br/>'; }?>
                <?php if (isset($lyric['Lyric']['composer'])){  echo __('Composer');?> : <?php echo $lyric['Lyric']['composer'],'<br/>'; }?>
                
                <?php echo __('Echelon');?>  : <?php echo $lyric['Lyric']['echelon'];?> <br/>
                </div><br>
        </div>
        <div id="content-container">
            <div id="content">
                <p id="title"><?php echo $lyric['Lyric']['title'];?></p>
                <?php echo str_replace(PHP_EOL,'<br/>',h($lyric['Lyric']['text']));?> 
                <br><br>
            </div>
        </div>
        <div id="footer">
            <div id="meta">
                <?php echo __('written by');?>: <?php echo $lyric['User']['name'];?> <?php echo $this->Time->format('d-m-Y',$lyric['Lyric']['created'],null),'<br/>';?> 
                <?php if (isset($lyric['Lyric']['modified']) && $lyric['Lyric']['modified'] != '0000-00-00 00:00:00'){echo __('last modified was at');?>: <?php echo $this->Time->format('d-m-Y',$lyric['Lyric']['modified'],null),'<br/>';}?> 
                <?php if (isset($lyric['Lyric']['source']) && $lyric['Lyric']['source']!=''){echo __('The source of this is from : %s',$lyric['Lyric']['source']);}?> <br/><br/><br/>
            </div>
            <p>
                <?php echo __('link');?> : <?php echo $this->Html->link($url);?><br>
            </p><br/><br/>
            <p align="center">
                <?php echo $this->Html->link('[www.HuneraKurdi.com]','http://www.hunerakurdi.com');?><br>
            </p>
        </div>
    </div>
</body>
</html>
