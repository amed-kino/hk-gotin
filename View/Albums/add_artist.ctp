<?php
 $imageUrlSmall = FULL_BASE_URL.'/wene/cuk/hunermend/'.$artist['Artist']['image'];
 ?>
<div id="driver">
    <ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index', $artist['Artist']['unique']),array());?></li>
    <li class="active"><?php echo __('New Album'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-album">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container">
                        <img class="img-responsive" src="<?php echo $imageUrlSmall;?>" />
                </div>
                <div class="info">
                    <div class="title"><?php echo __('New album for artist %s',$artist['Artist']['name']); ?></div>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Only Kurdish-Latin alphabet is allowed.'); ?></div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body add-artist-body clearfix">
 <?php echo $this->Form->create('Album'); ?>
    <fieldset>
        <div class="form-group">
            <p class="help-block"><?php echo __('Album Title');?></p>
            <?php echo $this->Form->input('title',array('label'=>false,'class'=>'form-control'));?>

        </div>            
        <div class="form-group">
            <p class="help-block"><?php echo __('Album Year');?></p>
            <?php echo $this->Form->input('year',array('required' => false, 'after' => '<span class="example">'.__('example').':1999</span>','label'=>false,'class'=>'form-control'));?>
        </div>
        <div class="form-group">
            <?php
            $requestSubmit=array(
                'class'=>'btn btn-md btn-primary',
                'escape' => FALSE,
                'type' => 'submit',);
            echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Save'), $requestSubmit);
            ?>  
        </div>
    </fieldset>                      
        </div>
    </section>
</main>