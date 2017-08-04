<?php
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
                    <div class="tips">
                        <span class="text-warning">*</span> <?php echo __('Select profile thumbnail and click upload.'); ?><br/>
                        <span class="text-warning">*</span> <?php echo __('Square photos will be saved directly.'); ?><br/>
                        <span class="text-warning">*</span> <?php echo __('Photo must be over 200x200.'); ?><br/>
                    </div>
               </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-photo-body clearfix">
            <div class="main col-lg-12 clearfix">
                    <?php echo $this->Form->create('uploadimage',array('enctype' => 'multipart/form-data'));?>
                        <div id="image_preview">
                            <?php echo $this->Html->image('endam/'.$user['User']['image'],array('id' => 'previewing'));?>
                        </div>
                        <hr id="line">
                        <div id="selectImage">
                        <label><?php echo __('Select Your Image');?></label><br/>
                            <input type="file" name="file" id="file" required onChange="Handlechange();" style="display: none;"/>
                            <button id="file" class="btn btn-default" type="button" value="<?php echo __('Click to select file'); ?>" onclick="HandleBrowseClick();"> <i class="glyphicon glyphicon-camera"></i> <?php echo __('Click to select file'); ?></button>
                            <button type="submit" class="submit btn btn-default pull-right"> <i class="glyphicon glyphicon-upload"> </i> <?php echo __('Upload');?></button>
                            <input type="text" id="filename"/>
                        </div>
                    <?php echo $this->Form->end();?>
                </div>
        </div>
    </section>
</main>
