<div class="panel panel-default">
    <div class="panel-heading">
            <i class="glyphicon glyphicon-paperclip"> </i> <?php echo __('Notes');?>:
    </div>
    <div class="box panel-body">

            <?php 
                foreach($messages as $message):
                    $marks = $this->HK->marks($message['Message']['marks']);
                    $related = $this->HK->related($message['Message']['related']);

            ?>
        
        <div id='message-item-<?php echo $message['Message']['id'];?>' class="message left clearfix">
                    <div class="header">
                        <span class="pull-left">
                            <div class="pull-left">
                                <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric"></i>',array('controller' => 'lyrics','action' => 'index',$related['lyric']),array('class' => 'btn btn-sm btn-action', 'escape' =>false));?>
                            </div>
                            <div class="username pull-left">
                                <span class="name"><?php echo $marks['name'];?></span><br/>
                                <span class="name"><?php echo $marks['email'];?></span>
                            </div>
                            
                        </span>
                        <span class="username pull-left"><em><?php echo $message['User1']['name'];?></em></span>
                        <small class="pull-right text-muted"> <i class="glyphicon glyphicon-time small"> </i> <?php echo $this->Time->timeAgoInWords($message['Message']['created']);?></small>
                        <div class="clearfix"></div>
                    </div>                                            
                    <div class="body">
                        <?php echo $this->Text->truncate($message['Message']['message'],256);?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php endforeach;   ?>
    </div>
</div>