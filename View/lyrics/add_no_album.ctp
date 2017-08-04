<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($artist['Artist']['name'],array('controller'=>'artists','action'=>'index', $artist['Artist']['unique']),array());?></li>
    <li class="active"><?php echo __('New lyric'); ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="lyric-no-album">
        <header class="page-header">
            <div class="header-content clearfix">
                 <div class="icon-container">
                <?php echo $this->Html->image('hunermend/cuk_'.$artist['Artist']['image']);?>
                </div>
                <div class="text-container">
                    <div class="info">
                        <span><?php echo __('No albums added for %s.','<em>'.$artist['Artist']['name'].'</em>');?></span><br/>
                        <?php echo __('This artist has no albums, so you have to choose one of below options.');?>
                    </div>
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body no-album-body clearfix">
            <div class="page-content col-lg-12 row">

        <div class="col-lg-4 option">
            <div class="option-title h4"><?php echo __('Album');?> <i class="glyphicon glyphicon-album"></i> </div>
            <p class="option-body">
                Hûn dikarin berhemekê li hunermend <em><?php echo $artist['Artist']['name'];?> </em>zêde bikin û despê bikin gotinan daxin.
            </p>
            <p><?php echo $this->Html->link('<i class="glyphicon glyphicon-album"></i> '.__('Add Album'),array('controller'=>'albums','action'=>'add',$artist['Artist']['unique']), array('escape' =>false, 'class'=>'btn btn-md  btn-primary'));?></p>
          </div>
          <div class="col-lg-4 option">
              <div class="option-title h4"><?php echo __('Artist');?> <i class="glyphicon glyphicon-artist"></i> </div>
                   <p class="option-body">
                        Hûn dikarin hunermend <em><?php echo $artist['Artist']['name'];?> </em>biguherin.
                    </p>
            <p><?php echo $this->Html->link('<i class="glyphicon glyphicon-artist"></i> '.__('Change Artist'),array('controller'=>'lyrics','action'=>'add'), array('escape' =>false,'class'=>'btn btn-md btn-primary'));?></p>
          </div>
          <div class="col-lg-4 option">
            
          </div>
        </div>
        </div>
    </section>
</main>