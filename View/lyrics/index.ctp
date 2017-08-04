<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
    
}

$artistUri = array(
    'artist' => $lyric['Artist']['name'],
);                    
$artistUrl = FULL_BASE_URL.'/hunermend'.$this->HK->uri($artistUri);

$albumUri = array(
                'artist' => $lyric['Artist']['name'],
                'album'  => $lyric['Album']['title'],
                'year'   => $lyric['Album']['year'],
            );                  
$albumUrl = FULL_BASE_URL.'/berhem'.$this->HK->uri($albumUri,'album');

$imageSize = '';
$imageUrl = FULL_BASE_URL.'/wene/berhem/'.$imageSize.$lyric['Album']['image'];
$imageSize = 'cuk_';
$imageUrlSmall = FULL_BASE_URL.'/wene/berhem/'.$imageSize.$lyric['Album']['image'];
 
echo $this->Html->meta(array('name' => 'description', 'content' => 'Gotinên strana '.$lyric['Lyric']['title'].' ya '.$lyric['Artist']['name'].' ji berhema '.$lyric['Album']['title'].'('.$lyric['Album']['year'].').'),'',array('inline'=>false));
echo $this->Html->meta(array('name' => 'author', 'content' => $lyric['User']['name']),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => $lyric['Artist']['name'].'-'.$lyric['Lyric']['title']),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'article:author', 'content' => FULL_BASE_URL.$this->Html->url(array('controller'=>'users','action'=>'profile',$lyric['User']['unique']))),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => $imageUrl),'',array('inline'=>false));
?>
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($lyric['Artist']['name'],$artistUrl,array());?></li>
    <li><?php echo $this->Html->link($lyric['Album']['title'].' ('.$lyric['Album']['year'].')',$albumUrl,array());?></li>            
    <li class="active"><?php echo $lyric['Lyric']['title'];?></li>
</ol>

<main id="main" class="site-main" role="main">
    <section id="lyric-view" class="clearfix">
        <header class="page-header view-lyric-header">
            <div class="main-info">
            <?php if ($lyric['Lyric']['available']!='yes'):?>
                <div class="text-danger error-message"><i class="glyphicon glyphicon-warning-sign"> </i> <?php echo __('The lyric is not available for public yet (need to be approved).');?></div>
            <?php endif; ?>                
                <div class="header-content col-lg-6 col-md-12">
                    <div>
                        <div class="icon-container">
                            <img class="img-responsive" src="<?php echo $imageUrlSmall;?>" />
                        </div>
                    
                    <div class="info">
                        <span class="lyric-title"><?php echo $lyric['Lyric']['title'];?></span> <br/>
                        <span class="artist-name"><?php echo $lyric['Artist']['name'];?></span><br/>
                        <span class="album-title"><?php echo $lyric['Album']['title'];?></span>
                        <span class="album-year">(<?php echo $lyric['Album']['year'];?>)</span>                         
                    </div>
                        
                      <div class="clearfix"></div>  
                    <div class="details">
                        <?php if ($lyric['Lyric']['writer'] != '' || $lyric['Lyric']['writer']!=null):?>
                        <span class="lyric-writer"><?php echo __('Writer : %s','<span class="writer-name">'.$lyric['Lyric']['writer'].'</span>');?></span> <br/>
                        <?php endif;?>
                        <?php if ($lyric['Lyric']['composer'] != '' || $lyric['Lyric']['composer']!=null):?>
                        <span class="lyric-composer"><?php echo __('Composer : %s','<span class="composer-name">'.$lyric['Lyric']['composer'].'</span>');?></span> <br/>
                        <?php endif;?>
                        <span class="lyric-echelon"><?php echo __('# : %s','<span class="echelon">'.$lyric['Lyric']['echelon'].'</span>');?></span>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-6 col-md-12 clearfix">
                        <?php echo $this->Element('lyric/entry-action');?>
                </div>
                <div class="col-lg-12">
                    <div class="entry-meta">
                        <?php echo $this->Element('lyric/entry-meta');?>
                    </div>
                </div>
             <div class="clearfix"></div>
            </div>
        </header>
        
        <div class="page-body view-lyric-body">
            <div class="col-lg-12 clearfix">
                <div class="download-btn-container">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon glyphicon-file"></i> <?php echo __('Download'); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Adobe PDF (.pdf)',array('controller'=>'download','action'=>'lyric','pdf',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> HTML (.htm)',array('controller'=>'download','action'=>'lyric','htm',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Rich Text (.rtf)',array('controller'=>'download','action'=>'lyric','rtf',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Text (.txt)',array('controller'=>'download','action'=>'lyric','txt',$lyric['Lyric']['unique']),array('escape'=>false));?></li>

                    </ul>
                  </div>
            </div>
            <div class="lyric-content"> 
                <p class="lyric-title"><?php echo $lyric['Lyric']['title'];?></p>
                <div class="lyric-text"><?php echo str_replace(PHP_EOL,'<br/>',$lyric['Lyric']['text']);?></div><div class="clearfix"></div>
            </div>
            
            <div class="lyric-margin">
                <?php
                if (isset($lyric['Lyric']['source']) && $lyric['Lyric']['source']!='') {
                    echo '<span class="source">';
                    
                    echo __('The source of this is from : %s','<i>'.$lyric['Lyric']['source'].'</i>');
                    
                    echo '</span><br/>';
                    
                }
                ?>
                
                <?php

                if (isset($lyric['Lyric']['editors']) && $lyric['Lyric']['editors']!=''){
                    
                    echo '<span class="editors">';
                    
                    $editorsArrayLength = sizeof($editors);
                    $editorsString = '';
                    $i=1;
                    
                    foreach ($editors as $editor) {
                        $editorLink = $this->Html->link($editor['User']['name'],array('controller' => 'users', 'action' => 'profile', $editor['User']['unique']));
                        $editorsString .= $editorLink;
                        if ($i != $editorsArrayLength){
                            $editorsString .= ' ';
                        }
                        $i++;
                    }
                    
                    echo __('Editors : %s',$editorsString);
                    
                    
                    
                    
                    echo '</span>';
                }
                        ?>
            </div>
            
        </div>
    </section>
</main>