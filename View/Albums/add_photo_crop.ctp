<?php
$defaultImage = 'https://hunerakurdi.com/demki/'.$this->Session->read('Upload.fileName');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.min.js', array('block' => 'scriptBottom'));
echo $this->Html->script('hk-cropper', array('block' => 'scriptBottom'));
$this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-default.css', null, array('inline' => false));

$albumYear = $album['Album']['title'].$this->HK->albumYear($album['Album']['year']);
$artistLink = $this->Html->link($album['Artist']['name'],array('controller' => 'artists', 'action' => 'index',$album['Artist']['unique']));
$albumLink = $this->Html->link($album['Album']['title'].$this->HK->albumYear($album['Album']['year']),array('controller'=>'albums','action'=>'index', $album['Album']['unique']),array());
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
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Select proper part and select crop.'); ?><br/></div>
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
<img src="<?php echo $defaultImage;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
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
                            
                            <?php echo $this->Html->link('<i class="glyphicon glyphicon-remove "> </i> '.__('cancel'),array('controller' => 'albums', 'action' => 'add','photo',$unique,'cancel'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>
                            <?php echo $this->Html->link('<i class="glyphicon glyphicon-trash"> </i> '.__('delete'),array('controller' => 'albums', 'action' => 'add','photo',$unique,'delete'),array('escape'=>false,'class' => 'btn btn-md btn-default'));?>    
                            <?php echo $this->Form->end();?>
                </div>
        </div>
    </section>
</main>