<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
}
$imageUrl = FULL_BASE_URL.'/wene/hunermend/'.$artist['Artist']['image'];
$imageUrlSmall = FULL_BASE_URL.'/wene/cuk/hunermend/'.$artist['Artist']['image'];
echo $this->Html->meta(array('name' => 'description', 'content' => 'Rûpela hunermend '.$artist['Artist']['name'].' li ser maplera HK. '.$artist['Artist']['album_counter'].' Berhem û '.$artist['Artist']['lyric_counter'].' Stran amade ne.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => $artist['Artist']['name']),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => $imageUrl),'',array('inline'=>false));
?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
        <li class="active"><?php echo $artist['Artist']['name'];?></li>
    </ol>

        <?php if($this->Session->check('Auth.User')):?>
            <?php if ($Acl['User'][3]):?>
                <?php echo $this->element('album/lyric_edit_hook_form');?>
            <?php endif;?>
            <div class="action dropdown">
                <button class="button dropdown-toggle btn btn-action" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i></button>
                <ul class="dropdown-menu pull-right">
                    <?php if($this->Session->check('Auth.User')):?>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-album"></i> '.__('Add album'),array('controller'=>'albums','action'=>'add', $artist['Artist']['unique']),array('escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add Album')));?></li>
                        <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add' ,'artist' ,$artist['Artist']['unique']),array('escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to %s.',$artist['Artist']['name'])));?></li>
                    <?php endif;?>

                        <?php if ($Acl['Artist'][2] || $artist['Artist']['user_id']==$this->Session->read('Auth.User.id')):?>
                        <li><?php echo '',$this->Html->link('<i class="glyphicon glyphicon-pencil"></i>'.__('Edit'),array('controller'=>'artists','action'=>'edit',$artist['Artist']['unique']), array('escape' =>FALSE,'data-toggle'=>'tooltip' ,'data-placement' => 'top' ,'title' => __('edit %s',$artist['Artist']['name']) )),'';?></li>
                        <?php endif;?>
                        <?php if ($Acl['Artist'][3] || $artist['Artist']['user_id']==$this->Session->read('Auth.User.id')):?>
                        <li><?php echo $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> '.__('Delete'), array('controller'=>'artists','action' => 'delete', $artist['Artist']['id']), array('class'=>'action-delete', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Delete artist %s.',$artist['Artist']['name']) ,'escape' => false,), __('Are you sure you want to delete %s?', $title));?></li>
                        <?php endif;?>
                </ul>
            </div>
        <?php else:?>
        <div class="request">
            <?php echo $this->Html->link('<i class="glyphicon glyphicon-hk-request"></i> <span class="hidden-xs">'.__('Request an artist').'</span>',array('controller'=>'requests','action'=>'artist'),array('class' => 'btn btn-default btn-action', 'escape' =>false, 'data-toggle' => 'tooltip' ,'data-placement' => 'top' ,'title' => __('Request an artist from HK.')));?>
        </div>
        <?php endif;?>
    
</div>
<main id="main" class="site-main" role="main">
    <section id="artist-view">
        <header class="page-header artist-header">
            <div class="main-info">
            <?php if ($artist['Artist']['available']!='yes'):?>
                <div class="text-danger error-message"><i class="glyphicon glyphicon-warning-sign"> </i> <?php echo __('The artist is not available for public yet (need to be approved).');?></div>
            <?php endif; ?>
                 <div class="col-lg-6 col-md-12 clearfix col-lg-push-6">
                </div>
                <div class="header-content col-lg-6 col-md-12 col-lg-pull-6 clearfix">
                    <div>
                        <div class="img-container">
                            <img class="img-responsive" src="<?php echo $imageUrlSmall;?>" />
                    </div>
                    
                    <div class="info">
                        <span class="artist-name"><?php echo $artist['Artist']['name'];?></span><br/>
                        <span class="albums"><?php echo __('Albums');?> (<?php echo $artist['Artist']['album_counter'];?>)</span><br/>
                        <span class="lyrics"><?php echo __('Lyrics');?> (<?php echo $artist['Artist']['lyric_counter'];?>)</span>
                    </div>
                      <div class="clearfix"></div>  
                    </div>
                </div>
               
             <div class="clearfix"></div>
            </div>
        </header>
        
        <div class="page-body artist-view-body clearfix">
            
            <?php if ($artist['Artist']['album_counter'] == 0 && $artist['Artist']['lyric_counter'] == 0):?>
            <div class="not-found col-lg-12 clearfix">
        
            <p class="clearfix">
                <?php echo __('Sorry, no content is ready yet for artist %s.','<em>' . $artist['Artist']['name'] . '</em>');?>
            </p>
            <p class="clearfix">
                <span class="albums"><?php echo __('Albums');?> (<?php echo $artist['Artist']['album_counter'];?>)</span><br/>
                <span class="lyrics"><?php echo __('Lyrics');?> (<?php echo $artist['Artist']['lyric_counter'];?>)</span>
            </p>
        
            </div>
            <?php else:?>
            <div class="col-lg-12">

                <?php foreach($artist['Album'] as $albums): ?>

                <div class="album-content clearfix">
                    
                    <div class="album-content-header clearfix">
                        <div class="icon-container">
                            <?php echo $this->Html->image('cuk/berhem/'.$albums['image'],array('width'=>80,'height'=>80));?>
                        </div>
                        <div class="info">
                            <?php
                                    $uri = array(
                                        'artist' => $artist['Artist']['name'],
                                        'album'  => $albums['title'],
                                        'year'   => $albums['year'],
                                    );
                                    $url = FULL_BASE_URL.'/berhem'.$this->HK->uri($uri);
                            ?> 
                            <span class="album-title"><?php echo $this->Html->link($albums['title'].$this->HK->albumYear($albums['year']),$url, array());?></span><br/>
                            <span class="lyrics"><?php echo __('Lyrics');?> (<?php echo sizeof($albums['Lyric']);?>)</span><br/>
                            <?php if($this->Session->check('Auth.User')):?>
                            <div class="action">
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> ',array('controller'=>'lyrics','action'=>'add' ,'album' ,$albums['unique']),array('escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to %s.',$albums['title'])));?>
                        <?php if ($Acl['Album'][2] || $albums['user_id']==$this->Session->read('Auth.User.id')):?>
                            <?php echo '',$this->Html->link('<i class="glyphicon glyphicon-pencil"></i>',array('controller'=>'albums','action'=>'edit',$albums['unique']), array('escape' =>FALSE,'data-toggle'=>'tooltip' ,'data-placement' => 'top' ,'title' => __('Edit album %s for artist %s.',$albums['title'],$artist['Artist']['name']) )),'';?>
                        <?php endif;?>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    
                    <div class="album-content-body clearfix">
                        <div class="album-content clearfix">
                            <?php
                            
                            
                            $album['Artist']['name'] = $artist['Artist']['name'];
                            $album['Album']['title'] = $albums['title'];
                            $album['Album']['year'] = $albums['year'];
                                    
                                echo $this->element('album/album_item',['album' => $album,'albumUnique' =>$albums['unique'] , 'Lyric' => $albums['Lyric'], 'Acl' => $Acl,]);
                            ?>
                        </div>
                    </div>
                    
                </div>
                        <?php endforeach;?>

            <div class="clearfix"></div>
        </div>
        <?php endif;?>
        </div>
    </section>
</main>