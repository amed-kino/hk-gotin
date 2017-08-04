<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Requests'),array('controller'=>'requests','action' => 'index'));?></li>
    <li class="active"><?php echo __('Album'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="request">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix">
                    <i class="glyphicon glyphicon-hk-request"> </i>
                </div>
                <div class="text-container">
			
                            <div class="title"><i class="glyphicon glyphicon-album"> </i> <?php echo __('Request an album from HK');?></div>
                            <div class="tips">
                                <?php echo __('Fill your name and Email, type your request message and press send to inform HK.');?><br/>
                                <?php echo __('Your request will be shown for public if you select to be public.');?>
                            </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
        

    <?php echo $this->Form->create('Request');?>                                      
        <div class="col-md-5">
            <div class="form-group">
                <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control','placeholder'=>__('Your Name')));?>
            </div>
            <div class="form-group">    
                <?php echo $this->Form->input('email',array('label'=>false,'class'=>'form-control','placeholder'=>__('Your Email')));?>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group input text required">
                <?php echo $this->Form->input('data',array('type'=>'textarea','label'=>false,'class'=>'form-control','placeholder'=>__('Your request message.'),'rows'=>'4'));?>

            </div>
        </div>
        
        <div class="input-group pull-right col-md-8 col-xs-11 col-md-pull-4 col-xs-pull-0">
            <p><?php echo __('Do you want to publish your request on public?');?></p>        
            <?php
                $options = array(
                    'yes' => __('Yes I want to show it to the public review.'),
                    'no' => __('No,keep it hide from public.only members will see it.'));
                $attributes = array('default'=>'yes','legend' => false,'separator'=>'<br/>');
                echo $this->Form->radio('public', $options, $attributes);
            ?>       
        </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                </div>
            <div class="clearfix"></div>
			<br/>			
            <p class="well well-sm"><?php echo __('Your email address will not be published,you will recive email when your request is found.');?></p>						

    <?php
        $requestSubmit=array(
            'class'=>'btn btn-md btn-primary',
            'escape' => FALSE,
            'type' => 'submit',);
        echo $this->Form->button(' <i class="glyphicon glyphicon-envelope"></i>  '.__('Request'), $requestSubmit);
    ?>
        </div>
    </section>
</main>