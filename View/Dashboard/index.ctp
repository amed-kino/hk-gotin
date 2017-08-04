<?php
if ($this->Session->check('Auth.Acl')){$Acl=$this->Session->read('Auth.Acl');}else{$Acl == null;}
?>
<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('Dashboard');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="dashboard">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-hk-dashboard"></i></div>
                <div class="text-container clearfix">
                    <div class="title">
                        <?php echo __('HK Dashboard');?><br/>
                        <?php echo __('This is control panel of the site.');?><br/>
                    </div>
                </div>
                <div class="tips-downward row">
                    <?php echo __('Through this dashboard you can add,edit and delete all contents such as artists,albums and lyrics.');?><br/>
                    <?php echo __("User's abilities depends on it's position,new user can just add lyrics and delete or edit thier owns.");?><br/>
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <div class="box-content col-lg-12 clearfix">
                <?php if ($Acl['Request'][3] == true){echo $this->element('dashboard/public_messages');}?>
            </div>
            <div class="inform col-lg-12  clearfix">
                <div class="notifications col-lg-6 col-sm-12 col-xs-12">
                    <?php echo $this->element('dashboard/notifications');?>
                </div>
                <div class="messages col-lg-6 col-sm-12 col-xs-12">
                    <?php echo $this->element('dashboard/messages');?>
                </div>    
            </div>
        <div class="approvals col-lg-12 clearfix">
            <?php if ($Acl['Request'][3] == true){echo $this->element('dashboard/approvals');}?>
        </div>
        </div>
    </section>
</main>