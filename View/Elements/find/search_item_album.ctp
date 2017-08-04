<div class="album-block media col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div class="album-image media-left">
            <?php if ($Album['image']==null){}else{echo $this->Html->image(BERHEM_DIC.'cuk_'.$Album['image'],array('width'=>80,'height'=>80));} ?> 
        </div>
        <div class="album-description media-body">
                
            <span class="title"><?php echo $this->Html->link($Album['title'],array('controller'=>'albums','action'=>'index',$Album['unique']));?></span><br/>
            <span class="name"><?php echo $Artist['name'];?></span><br/>
            <span class="year">(<?php echo $Album['year'];?>)</span><br/>
            <span class="number"><?php echo __('%s lyrics',$Album['lyric_counter']);?></span>
                
        </div><div class="clearfix"></div>
</div>
