<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading">
        <?php echo __('Approvals');?>
    </div>
    <div class="panel-body">
        <div class="">
            <ul class="nav nav-tabs nav-tabs-justified nav-pills">
            <li><a href="#tab1default" data-toggle="tab"><?php echo __('Artists');?> (<?php echo sizeof($artists);?>)</a></li>
            <li><a href="#tab2default" data-toggle="tab"><?php echo __('Albums');?> (<?php echo sizeof($albums);?>)</a></li>
            <li class="active"><a href="#tab3default" data-toggle="tab"><?php echo __('Lyrics');?> (<?php echo sizeof($lyrics);?>)</a></li>
            </ul>
            <hr/>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="tab1default">
                <h5><?php echo __('Artist');?></h5>
                <table id="artist-approvals" class="table-hover">
                    <?php 
                        foreach ($artists as $artist):
                        $text = '<small class="text-muted"> '.__('By ') .' '.$this->Html->link($artist['User']['name'],array('controller' => 'users', 'action' => 'profile', $artist['User']['unique'])).'</small>';
                       
                    ?>
                    <tr>
                        <td class="view-button"><i class="glyphicon glyphicon-artist"></i></td>
                        <td>
                            <?php
                                echo $artist['Artist']['name'],
                                '',
                                $text;
                            ?>
                        </td>
                        <td><small class="pull-left text-muted"> <i class="glyphicon glyphicon-time small"> </i> <?php echo $this->Time->timeAgoInWords($artist['Artist']['created']);?></small></td>
                        <td class="action">
                            <span class="ajax-loader"></span>
                            <span class="action">
                                <button class="action-accept btn btn-sm btn-success" data-type="Artist" data-unique="<?php echo $artist['Artist']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('accept %s',$artist['Artist']['name']);?>'"><i class="glyphicon glyphicon-ok"></i></button>&nbsp;
                                <button class="action-delete btn btn-sm btn-danger " data-type="Artist" data-unique="<?php echo $artist['Artist']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('remove %s',$artist['Artist']['name']);?>'"><i class="glyphicon glyphicon-remove"></i></button>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach;   ?>
                    </table>
                
            </div>
            
            <div class="tab-pane fade" id="tab2default">
                <h5><?php echo __('Albums');?></h5>
                <table id="album-approvals" class="table-hover">
                    <?php 
                       foreach ($albums as $album):
                        $text = $album['Album']['title'] . ' - ' .$album['Artist']['name'] . __('By ') .'<small class="text-muted">'.$this->Html->link($album['User']['name'],array('controller' => 'users', 'action' => 'profile', $album['User']['unique'])).'</small>';
                       
                    ?>
                    <tr>
                        <td class="view-button"><i class="glyphicon glyphicon-album"></i></td>
                        <td><?php echo $album['Album']['title'] . ' - ' .$album['Artist']['name'];?></td>
                        <td><small class="pull-left text-muted"> <i class="glyphicon glyphicon-time small"> </i> <?php echo $this->Time->timeAgoInWords($album['Album']['created']);?></small></td>
                        <td class="action">
                            <span class="ajax-loader"></span>
                            <span class="action">
                                <button class="action-accept btn btn-sm btn-success" data-type="Album" data-unique="<?php echo $album['Album']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('accept %s',$album['Album']['title']);?>'"><i class="glyphicon glyphicon-ok"></i></button>&nbsp;
                                <button class="action-delete btn btn-sm btn-danger " data-type="Album" data-unique="<?php echo $album['Album']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('remove %s',$album['Album']['title']);?>'"><i class="glyphicon glyphicon-remove"></i></button>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach;   ?>
                    </table>
                
            </div>
            <div class="tab-pane fade in active" id="tab3default">
                <h5><?php echo __('Lyrics');?></h5>
                <table id="lyric-approvals" class="table-hover">
                    <?php 
                        foreach ($lyrics as $lyric):
                        $text = $lyric['Lyric']['title'] . ' - ' .$lyric['Artist']['name'] . __('By ') .'<small class="text-muted">'.$this->Html->link($lyric['User']['name'],array('controller' => 'users', 'action' => 'profile', $lyric['User']['unique'])).'</small>';
                    ?>
                    <tr>
                        <td class="view-button"><button class="view btn btn-sm btn-default" onclick="lyricModal('<?php echo $lyric['Lyric']['unique'];?>');"><i class="glyphicon glyphicon-lyric"></i></button></td>
                        <td><?php echo $lyric['Lyric']['title'] . ' - ' .$lyric['Artist']['name'];?></td>
                        <td><small class="pull-left text-muted"> <i class="glyphicon glyphicon-time small"> </i> <?php echo $this->Time->timeAgoInWords($lyric['Lyric']['created']);?></small></td>
                        <td class="action">
                            <span class="ajax-loader"></span>
                            <span class="action">
                                <button class="action-accept btn btn-sm btn-success" data-type="Lyric" data-unique="<?php echo $lyric['Lyric']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('accept %s',$lyric['Lyric']['title']);?>'"><i class="glyphicon glyphicon-ok"></i></button>&nbsp;
                                <button class="action-delete btn btn-sm btn-danger " data-type="Lyric" data-unique="<?php echo $lyric['Lyric']['unique'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo __('remove %s',$lyric['Lyric']['title']);?>'"><i class="glyphicon glyphicon-remove"></i></button>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lyricModal" tabindex="-1" role="dialog" aria-labelledby="lyricModalLabel" aria-hidden="true">      
    <div class="modal-dialog">
        <div class="modal-content lyric-modal">
            <div class="loading-text "><?php echo __('Loading');?>......<div class="clearfix"></div></div>
            <div class="toggle-content">
                
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="title">
                <span class="artist-name"></span> - <span class="album-title"></span> (<span class="album-year"></span>)
            </div>

            <div class="subtitle">
                <?php echo __('Writer');?>: <span class="lyric-writer"></span><br/>
                <?php echo __('Composer');?>: <span class="lyric-composer"></span><br/>
                <?php echo __('Echelon');?>: <span class="lyric-echelon"></span><br/>
            </div>
          </div>
                <div class="modal-body">
                    <div class="lyric-title"></div>
                    <div class="lyric-text"></div>
                </div>
                <div class="modal-footer">
                    <div class="lyric-source pull-left">No where</div><br/>
                    <div class="user-name pull-left">Amed</div>
                </div>
        
               <div class="clearfix"></div> 
            </div>
        </div>
    </div>
    </div>










