<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
    <div class="upper-container clearfix">
            <div class="jp-time-holder">
                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
            </div>        
        <div class="jp-progress">
                 <div class="jp-seek-bar">
                     <div class="jp-play-bar"></div>
                 </div>
        </div>
        
    </div>
    <div class="lower-container">
        <div class="logo-container col-sm-3 col-xs-12">
            <img src="/wene/HKPlay-Logo.png" width="120" height="120"/>
        </div>    
        
        <div class="control-container col-sm-6 col-xs-12">
                
            <div class="download-container">
                <?php
                
                $songHref = '';
                if (strstr($lyric['Lyric']['file'], 'http')){
                    $songHref = $lyric['Lyric']['file'];
                }else{
                    $songHref = FULL_BASE_URL.'/stran/'.$lyric['Lyric']['file'];
                }
                ?>
                <a class="btn btn-md jp-download" href="<?php echo $songHref;?>" download>
                    <?php echo __('Download');?>
                </a>
            </div>
            <div class="jp-controls">
                <button class="jp-stop" role="button" tabindex="0"></button>
                                          
                <button class="jp-play" role="button" tabindex="0"></button>
 <div class="jp-toggles">
                    <button class="jp-repeat" role="button" tabindex="0"></button>
                </div> 
            </div>
        </div>    
        <div class="audio-container col-sm-3 hidden-xs">
             <div class="jp-volume-controls">
                    <i class="jp-mute glyphicon glyphicon-volume-up" role="button" tabindex="0"></i>
                    <i class="jp-volume-max glyphicon glyphicon-volume-up" role="button" tabindex="0"></i>
                    <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                    </div>
            </div>
        </div>    
        
        
        
        
        <div class="clearfix"></div>
        
    </div>

	
</div>
