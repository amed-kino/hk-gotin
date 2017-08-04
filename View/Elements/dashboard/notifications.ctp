<div class="panel panel-default">
	<div class="panel-heading">
            <i class="glyphicon glyphicon-exclamation-sign"> </i> <?php echo __('Notifications');?>:
	</div>
	<div class="box panel-body">
            
                <?php 
                    foreach ($notifications as $notification ):
                    $text = $this->HK->notification($notification);
                ?>
            
                    
                    <?php echo $text['moreLink']==null?'':'<a href="'.$text['moreLink'].'">';?>
                    <div class="notification left clearfix">
                        <div class="icon pull-left"><?php echo $text['icon'];?></div>
                        <div class="note pull-left">
                            
                            <div class="text"><?php echo $text['text'];?></div>
                            <div class="time"><i class="glyphicon glyphicon-time small"> </i> <?php echo $this->Time->timeAgoInWords($text['created']);?></div>
                        </div>    
                    </div>
                    <?php echo $text['moreLink']==null?'':'</a>';?>
                <?php endforeach;   ?>

	</div>

	<div class="panel-footer">
		<div class="input-group">

		</div>
	</div>

</div>