<?php
$defaultImage = 'https://hunerakurdi.com/demki/'.$this->Session->read('Upload.fileName');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js', array('block' => 'scriptBottom'));
echo $this->Html->script('hk-cropper', array('block' => 'scriptBottom'));
$this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-default.css', null, array('inline' => false));

$userLink = $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
    <li><?php echo $userLink;?></li>
    <li><?php echo $this->Html->link(__('Settings'),array('controller'=>'users','action' => 'settings',$user['User']['unique']));?></li>
    <li class="active"><?php echo __('Photo') ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-user-photo">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                    <?php echo $this->Html->image('cuk/endam/'.$user['User']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Change photo for %s','<em>'.$user['User']['name'].'</em>');?>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Select proper part and select crop.'); ?><br/></div>
               </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-artist-photo-body clearfix">
                
                <div class="main col-lg-12 clearfix"><img src="<?php echo $defaultImage;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
                    <div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:200px; height:200px;">
                            <input id="photoH" type="hidden" name="photoH" value="<?php echo $this->Session->Read('Upload.fileH');?>" />
                            <input id="photoW" type="hidden" name="photoW" value="<?php echo $this->Session->Read('Upload.fileW');?>" />
                            <img src="<?php echo $defaultImage;?>" style="position: relative;" alt="Thumbnail Preview" />
                    </div>

                    <br style="clear:both;"/>
                    <hr class="clearfix" />
                        <?php echo $this->Form->create('PhotoCropper');?>

                            <input type="hidden" name="crop" value="do" />
                            <input type="hidden" name="x1" value="" id="x1" />
                            <input type="hidden" name="y1" value="" id="y1" />
                            <input type="hidden" name="x2" value="" id="x2" />
                            <input type="hidden" name="y2" value="" id="y2" />
                            <input type="hidden" name="w" value="" id="w" />
                            <input type="hidden" name="h" value="" id="h" />
                            <button type="submit" class="submit btn btn-default pull-right"> <i class="glyphicon glyphicon-check"> </i> <?php echo __('Crop');?></button>
                            
                            <?php echo $this->Html->link('<i class="glyphicon glyphicon-remove "> </i> '.__('cancel'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'cancel'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                            <?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"> </i> '.__('delete'),array('controller' => 'users', 'action' => 'settings','photo',$unique,'delete'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                        <?php echo $this->Form->end();?>
                </div>
                
            </div>
    </section>
</main>