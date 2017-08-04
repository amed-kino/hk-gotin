    <?php
    $destinationLogged =    array('controller'=>'lyrics','action'=>'edit',$lyric['Lyric']['unique']);
    $destinationNotLogged = array('controller'=>'lyrics','action'=>'note',$lyric['Lyric']['unique']);
    $destination = ($this->Session->check('Auth.Acl'))? $destinationLogged : $destinationNotLogged;
    ?>
<ul>
    <li>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs">'.__('Edit').'</span>',$destination, array('class' => 'btn btn-default btn-action', 'escape' =>FALSE, 'data-toggle' =>'tooltip' ,'data-placement' => 'top', 'title' => __('Edit %s',$lyric['Artist']['name'].'-'.$lyric['Lyric']['title'])));?>
    </li>
</ul>


<div class="col-xs-12 clearfix">
    <div class="download-btn-container pull-right">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon glyphicon-file"></i> <?php echo '<span class="hidden-xs">'.__('Download').'</span>'; ?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Adobe PDF (.pdf)',array('controller'=>'download','action'=>'lyric','pdf',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
            <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> HTML (.htm)',array('controller'=>'download','action'=>'lyric','htm',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
            <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Rich Text (.rtf)',array('controller'=>'download','action'=>'lyric','rtf',$lyric['Lyric']['unique']),array('escape'=>false));?></li>
            <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-file"></i> Text (.txt)',array('controller'=>'download','action'=>'lyric','txt',$lyric['Lyric']['unique']),array('escape'=>false));?></li>

        </ul>
    </div>
</div>