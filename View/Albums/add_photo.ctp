<?php
$albumYear = $album['Album']['title'].$this->HK->albumYear($album['Album']['year']);
$artistLink = $this->Html->link($album['Artist']['name'],array('controller' => 'artists', 'action' => 'index',$album['Artist']['unique']));
$albumLink = $this->Html->link($albumYear,array('controller'=>'albums','action'=>'index', $album['Album']['unique']),array());
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $artistLink;?></li>
    <li><?php echo $albumLink ;?></li>
    <li class="active"><?php echo __('Change photo'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-photo">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                <?php echo $this->Html->image('cuk/berhem/'.$album['Album']['image']);?>
                </div>
               <div class="info">
                   <?php echo __('Change photo for %s','<em>'.$albumYear.' - '.$album['Artist']['name'].'</em>');?>
                    <div class="tips">
                        <span class="text-warning">*</span> <?php echo __('Select album thumbnail and click upload.'); ?><br/>
                        <span class="text-warning">*</span> <?php echo __('Square photos will be saved directly.'); ?><br/>
                        <span class="text-warning">*</span> <?php echo __('Photo must be over 200x200.'); ?><br/>
                    </div>
               </div>
                <div class="information">
                    <div class="pull-right links">
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> '.__('Edit'),array('controller' => 'albums', 'action' => 'edit',$album['Album']['unique']),array('escape'=>false,'class' => 'btn btn-sm btn-default btn-action','data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Edit album %s.',$albumYear)));?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i> '.__('Add lyric'),array('controller'=>'lyrics','action'=>'add' ,'album' ,$album['Album']['unique']),array('class' => 'btn btn-sm btn-default btn-action','escape' =>false, 'data-toggle'=>'tooltip' ,'data-placement'=>'top' ,'title' =>__('Add lyric to album %s.',$albumYear)));?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        <div class="page-body add-photo-body clearfix">
            <div class="main col-lg-12 clearfix">
                <?php echo $this->Form->create('uploadimage',array('enctype' => 'multipart/form-data'));?>
                    <div id="image_preview">
                        <?php echo $this->Html->image('berhem/'.$album['Album']['image'],array('id' => 'previewing'));?>
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