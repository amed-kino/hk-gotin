<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');
}else{
    $Acl=null;
}
echo $this->Html->meta(array('name' => 'description', 'content' => 'Berhema '.$album['Album']['title'].$this->HK->albumYear($album['Album']['year']).' ya '.$album['Artist']['name'].'. ('.$album['Album']['lyric_counter'].') stran. Gotinê stranê vê berhemê di nava vê girêdanê de ne.'),'',array('inline'=>false));
echo $this->element('basic_meta_keywords');
echo $this->Html->meta(array('property' => 'og:title', 'content' => $album['Artist']['name'].'-'.$album['Album']['title'].$this->HK->albumYear($album['Album']['year'])),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/berhem/'.$album['Album']['image']),'',array('inline'=>false));
$uri = array(
    'artist' => $album['Artist']['name'],
);                    
 $artistUrl = FULL_BASE_URL.'/hunermend'.$this->HK->uri($uri);
 $imageUrlSmall = FULL_BASE_URL.'/wene/cuk/berhem/'.$album['Album']['image'];
?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
        <li><?php echo $this->Html->link($album['Artist']['name'],$artistUrl,array());?></li>      
        <li class="active"><?php echo $album['Album']['title'].$this->HK->albumYear($album['Album']['year']);?></li>
    </ol>            
        <?php if($this->Session->check('Auth.User')):?>
    <?php if ($Acl['User'][3]):?>
                <?php echo $this->element('album/lyric_edit_hook_form');?>
            <?php endif;?>
            <div class="action dropdown">
                <button class="button dropdown-toggle btn btn-action" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i></button>
                <ul class="dropdown-menu pull-right">
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add','album', $album['Album']['unique']),array('escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to album %s for %s.',$album['Album']['title'],$album['Artist']['name'])));?></li>
                    <?php if($Acl['Album'][2] || $album['Album']['user_id']==$this->Session->read('Auth.User.id')):?>
                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> '. __('Edit'),array('controller'=>'albums','action'=>'edit',$album['Album']['unique']), array('escape' => FALSE, 'data-toggle' => 'tooltip' ,'data-placement' => 'top' ,'title' => __('Edit album %s for %s.',$album['Album']['title'],$album['Artist']['name'])));?></li>
                    <?php endif;?>
                    <?php if ($Acl['Album'][3] || $album['Album']['user_id']==$this->Session->read('Auth.User.id')):?>
                    <li><?php echo $this->Form->postLink('<i class="glyphicon glyphicon glyphicon-trash"></i> '.__('Delete'), array('controller'=>'albums','action' => 'delete', $album['Album']['id']), array('class'=>'action-delete', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Delete album %s from %s.',$album['Album']['title'],$album['Artist']['name']) ,'escape' => false,), __('Are you sure you want to delete %s?', $title));?></li>
                    <?php endif;?>
                </ul>
            </div>
        <?php else:?>
    <div class="request">
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-hk-request"></i> <span class="hidden-xs">'.__('Request an album').'</span>',array('controller'=>'requests','action'=>'album'),array('class' => 'btn btn-default btn-action', 'escape' =>false, 'data-toggle' => 'tooltip' ,'data-placement' => 'top' ,'title' => __('Request an album from HK.')));?>
    </div>
    <?php endif;?>
</div>
<main id="main" class="site-main" role="main">
    <section id="album-view" class="clearfix">
        <header class="page-header album-header">
            <div class="main-info">
                <?php if ($album['Album']['available']=='no' || $album['Album']['deleted']=='yes'):?>
                    <div class="text-danger error-message"><i class="glyphicon glyphicon-warning-sign"> </i> <?php echo __('The album is not Available for public yet (need to be approved).');?></div>
                <?php endif; ?>
            </div>
                <div class="header-content col-lg-6 clearfix">
                    <div>
                    <div class="img-container">
                            <img class="img-responsive" src="<?php echo $imageUrlSmall;?>" />
                    </div>
                    <div class="info">
                       <span class="artist-name"><?php echo $this->Html->link($album['Artist']['name'],$artistUrl,array());?></span><br/>
                        <span class="album-title"><?php echo $album['Album']['title'];?> <?php echo $this->HK->albumYear($album['Album']['year']);?></span><br/>
                        <span class="lyric-count"><?php echo __('Lyrics');?> (<?php echo sizeof($album['Lyric']);?>)</span>
                    </div>
                      <div class="clearfix"></div>  
                    </div>
                </div>
               
             <div class="clearfix"></div>
        </header>
        <div class="page-body album-view-body clearfix">
                <div class="album-content clearfix">
                        <?php
                            echo $this->element('album/album_item',['albumUnique' =>$album['Album']['unique'] , 'Lyric' => $album['Lyric'], 'Acl' => $Acl,]);
                        ?>
                </div>
            <div class="clearfix"></div>

        </div>
    </section>
</main>