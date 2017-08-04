<div id="driver">
<ol class="breadcrumb">
    <li class="active"><?php echo __('Request'); ?></li>
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
                    <div class="title">
                        <?php echo __('Request from HK');?>
                    </div>
                    <div class="tips">
                        <?php echo __('Through request panel you will be able to request what you need, or what we missed.');?><br/>
                        <?php echo __('Please select what you need bellow.');?>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <div class="row clearfix">

    <div class="col-lg-4 request-section">
        <div class="request-header clearfix">
            <div class="request-icon-container">
                <i class="glyphicon glyphicon-artist"></i> 
            </div>
            <div class="request-title">
                <?php echo $this->Html->link(__('Artist'),array('controller'=>'requests','action'=>'artist'),array());?>
            </div>
        </div>
      <p class="request-body">
          Hûn dikarin hunermendê ku bixwazin lê bipirsin, Endamên HK wê bikaribin alîkariya we bikin.
      </p>
      <p><?php echo $this->Html->link(__('Artist'),array('controller'=>'requests','action'=>'artist'),array('class'=>'btn btn-default'));?></p>
    </div>
                
                
                
    <div class="col-lg-4 request-section">
        <div class="request-header clearfix">
            <div class="request-icon-container">
                <i class="glyphicon glyphicon-album"></i> 
            </div>
            
            <div class="request-title">
                <?php echo $this->Html->link(__('Album'),array('controller'=>'requests','action'=>'album'),array());?>
            </div>
        </div>
      <p class="request-body">
          Hûn dikarin berhemekê ji berhemên hunermendekî taybet bixwazin û lê bipirsin, Endamên HK wê bikaribin alîkariya we bikin.
      </p>
      <p><?php echo $this->Html->link(__('Album'),array('controller'=>'requests','action'=>'album'),array('class'=>'btn btn-default'));?></p>
    </div>
                
                
    <div class="col-lg-4 request-section">
        <div class="request-header clearfix">
            <div class="request-icon-container">
                <i class="glyphicon glyphicon-lyric"></i> 
            </div>
            <div class="request-title">
                <?php echo $this->Html->link(__('Lyric'),array('controller'=>'requests','action'=>'lyric'),array());?>
            </div>
        </div>
      <p class="request-body">
          Hûn dikarin gotinên stranan ji berhemên hunermendan bixwazin û lê bipirsin, Endamên HK wê bikaribin alîkariya we bikin.
      </p>
      <p><?php echo $this->Html->link(__('Lyric'),array('controller'=>'requests','action'=>'lyric'),array('class'=>'btn btn-default'));?></p>
    </div>
    </div>
    
    
<?php if (!empty($requests)):?>
    <hr class="clearfix"/>
    <div id="requests-recent" class="row">
        <div class="title">
            <i class="glyphicon glyphicon-hk-request"></i> 
            <?php echo __('Recent requests');?>
        </div>
        <ul>
            <?php foreach ($requests as $request):?>
            <li>
                <?php echo $this->element('request/request_item',$request);?>
            </li>
            <?php endforeach;?>
        </ul>
        <div class="clearfix"></div>
        <?php if (sizeof($requests)<10):?>
            <div class="pull-right col-lg-7">
            <?php echo $this->Html->link(__('More Requests'),array('controller'=>'requests','action'=>'panel'));?>
            </div>
        <?php endif;?>
    </div>
<?php endif;?>    
        </div>
    </section>
</main>
