<?php
$image = 'https://hunerakurdi.com/demki/'.$this->Session->read('Upload.thumb');
$userLink = $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
    <li><?php echo $userLink;?></li>
    <li><?php echo $this->Html->link(__('Settings'),array('controller'=>'users','action' => 'Settings',$user['User']['unique']));?></li>
    <li class="active"><?php echo __('Photo') ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-photo">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                    <?php echo $this->Html->image('cuk/endam/'.$user['User']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Change photo for %s','<em>'.$user['User']['name'].'</em>');?>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Select accept to save current photo view to %s photo.',$user['User']['name']); ?></div>
               </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-photo-body clearfix">
            <div class="board col-lg-10">
                
                <div class="main col-lg-12 clearfix">
                    <div class="image-panorama">
                        <img src="<?php echo $image;?>" height="200" width="200"/>
                        <img src="<?php echo $image;?>" height="180" width="180"/>
                        <img src="<?php echo $image;?>" height="120" width="120"/>
                        <img src="<?php echo $image;?>" height="80" width="80"/>
                    </div>
                    
                    
                    <hr class="clearfix"/>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-ok "> </i> '.__('accept'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'accept'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-remove "> </i> '.__('cancel'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'cancel'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-refresh "> </i> '.__('recrop'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'recrop'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-trash "> </i> '.__('delete'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'delete'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                </div>
                
            </div>
        </div>
    </section>
</main>