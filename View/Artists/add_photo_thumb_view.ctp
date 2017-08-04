<?php
$image = 'https://hunerakurdi.com/demki/'.$this->Session->read('Upload.thumb');
?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
        <li><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index', $artist['Artist']['unique']),array());?></li>
        <li class="active"><?php echo __('Change photo'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-photo">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                <?php echo $this->Html->image('cuk/hunermend/'.$artist['Artist']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Change photo for %s','<em>'.$artist['Artist']['name'].'</em>');?>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Select accept to save current photo view to %s photo.',$artist['Artist']['name']); ?></div>
               </div>
                <div class="information">
                    <div class="pull-right links">
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> '.__('Edit'),array('controller' => 'artists', 'action' => 'edit',$artist['Artist']['unique']),array('escape'=>false,'class' => 'btn btn-sm btn-default btn-action','data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Edit artist %s',$artist['Artist']['name'])));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-album"></i> '.__('Add album'),array('controller'=>'albums','action'=>'add', $artist['Artist']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add album to %s.',$artist['Artist']['name'])));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add' ,'artist' ,$artist['Artist']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to %s.',$artist['Artist']['name'])));?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-photo-body clearfix">
            <div class="board col-lg-10">

                <div class="image-panorama">
                    <img src="<?php echo $image;?>" height="200" width="200"/>
                    <img src="<?php echo $image;?>" height="180" width="180"/>
                    <img src="<?php echo $image;?>" height="120" width="120"/>
                    <img src="<?php echo $image;?>" height="80" width="80"/>
                </div>


                
                <hr class="clearfix"/>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-ok "> </i> '.__('accept'),array('controller' => 'artists', 'action' => 'add','photo',$unique,'accept'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-remove "> </i> '.__('cancel'),array('controller' => 'artists', 'action' => 'add','photo',$unique,'cancel'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-refresh "> </i> '.__('recrop'),array('controller' => 'artists', 'action' => 'add','photo',$unique,'recrop'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                <?php echo $this->Html->link('<i class="glyphicon glyphicon-trash "> </i> '.__('delete'),array('controller' => 'artists', 'action' => 'add','photo',$unique,'delete'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
            </div>       
        </div>
    </section>
</main>