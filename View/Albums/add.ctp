<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo __('Add');?></li>
        <li class="active"><?php echo __('Album');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-album">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-album"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('New album'); ?></div>
                    <div class="tips"><span class="text-warning">*</span> <?php echo __('Only Kurdish-Latin alphabet is allowed.'); ?></div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body add-artist-body clearfix">
            <?php echo $this->Form->create('Album'); ?>
    <div class="form-group">
        <p class="help-block"><?php echo __('Artist Name');?></p>
        <?php echo $this->Form->input('artist_id',array('empty' =>'','label'=>false,'class'=>'form-control'));?>


    </div>
    <div class="form-group">
        <p class="help-block"><?php echo __('Album Title');?></p>
        <?php echo $this->Form->input('title',array('label'=>false,'class'=>'form-control'));?>

    </div>
    <div class="form-group">
        <p class="help-block"><?php echo __('Album Year');?></p>
        <?php echo $this->Form->input('year',array('after' => '<span class="example">'.__('example').':1999</span>','label'=>false,'class'=>'form-control'));?>

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
         <?php echo $this->Form->end(); ?>           
        </div>
    </section>
</main>