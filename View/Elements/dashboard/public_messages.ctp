<div class="box-item col-lg-3 col-md-6"> 
    <a href="<?php echo Router::url(array('controller' =>'dashboard','action' => 'messages'),true);?>">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="title"><?php echo __('Public messages');?></div>
                    <div class="clearfix">
                        <div class="box-icon col-xs-3">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                        <div class="statics">
                            <div><?php echo __('%s messages',$publicMessages['all']);?></div>
                            <div>(<?php echo __('%s unreads',$publicMessages['unread']);?>)</div>
                        </div>

                    </div>
                    </div>
                </div>
            </div>

                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <div class="clearfix"></div>
                </div>

        </div>
    </a>
</div>