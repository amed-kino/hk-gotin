<div class="artist-block media col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div class="artist-image media-left">
            <?php
                if ($Artist['image']==null){}else{
                    $_image = FULL_BASE_URL.'/wene/tun/hunermend/'.$Artist['image'];
                    //HUNER_DIC.'cuk_'.$Artist['image']
                    echo $this->Html->image($_image, array('width'=>80,'height'=>80));
                }
            ?>
        </div>
        <div class="artist-description media-body">
            <div class="name">
                    <?php echo $this->Html->link($Artist['name'],array('controller'=>'artists','action'=>'index',$Artist['unique']));?>
            </div>
            <div class="meta">
                
                <div class="album small"><?php echo __('Albums');?> (<?php echo $Artist['album_counter'];?>) </div>
                <div class="lyric small"><?php echo __('Lyrics');?> (<?php echo $Artist['lyric_counter'];?>) </div>
                
            </div>
        </div><div class="clearfix"></div>
</div>
