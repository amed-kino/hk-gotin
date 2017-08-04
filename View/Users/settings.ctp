<?php 
Configure::load('links');
$links = Configure::read('HK.links');

$url = 'https://hunerakurdi.com/wene/';

$imageUrl       = $url.'mzn/endam/'.$user['User']['image'];
$imageUrlSmall  = $url.'tun/endam/'.$user['User']['image'];

?>
<?php if ($this->Session->check('Auth.Acl')){ $Acl=$this->Session->read('Auth.Acl'); }else{ $Acl=null;}?>
<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
        <li><?php echo $this->Html->link($user['User']['name'],array('controller'=>'users','action' => 'profile',$user['User']['unique']));?></li>
        <li class="active"><?php echo __('Settings'); ?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="user-settings">
        <header class="page-header clearfix">
            <div class="header-content clearfix">
                <div class="icon-container clearfix">
                    <img src="<?php echo $imageUrlSmall;?>"/>
                </div>
                <div class="info clearfix">
                    <div class="title"><?php echo __('Settings'); ?></div>
                    <div class="description">
                        <?php echo $user['User']['name'];?>
                    </div>
                </div>
                <div class="information">
                    <div class="pull-right links">
                        <a data-toggle="modal" data-target="#passwordModal" class="btn btn-default btn-action" href="#"><i class="glyphicon glyphicon-lock"></i> <?php echo __('Change your password');?></a>
                    </div>
                </div>
            </div>
            <input id="changePasswordLink" type="hidden" name="changePasswordLink" value="<?php echo $links['changePassword'];?>" />
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));?>
        </header>
        
        <div class="page-body users-settings-body clearfix">

            <p><?php echo __('Here is your main settings');?><br/></p>
            <p></p>
            
            
                <?php echo $this->Form->create('User');?>
                
                <div class="col-lg-3 col-md-6 image-change-container">
                    <img src="<?php echo $imageUrl;?>"/>
                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-picture"></i> '.__('Change your picture'),array('controller' => 'users', 'action' => 'settings','photo', $unique),array('class' => 'btn btn-default btn-action','escape' => false));?>
                </div>
                <div class="col-lg-9 col-md-6"><div class="col-lg-10">
                    <div class="form-group">
                        <p class="help-block"><?php echo __('User name');?></p>
                        <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control'));?>   
                    </div>
                    <div class="form-group">
                        <p class="help-block"><?php echo __('First name');?></p>
                        <?php echo $this->Form->input('first_name',array('label'=>false,'class'=>'form-control'));?>   
                    </div>
                    <div class="form-group">
                        <p class="help-block"><?php echo __('Last name');?></p>
                        <?php echo $this->Form->input('last_name',array('label'=>false,'class'=>'form-control'));?>   
                    </div>
                </div></div>
                <div class="col-lg-12"><hr/>
                <div class="col-lg-3"></div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <p class="help-block"><?php echo __('Biography');?> <span class="small">(<?php echo __('%s Letters',256);?>)</span></p>
                        <?php echo $this->Form->textarea('infos',array('label'=>false,'class'=>'infos form-control','maxlength' => '255'));?>   
                    </div>
                    <div class="form-group">
                        <p class="help-block"><?php echo __('Birthday');?></p>
                        <?php echo $this->Form->input('birthday', array('class'=>'birthday','label'=>false,'dateFormat'=>'D M Y', 'minYear'=>'1929', 'maxYear'=>'2009', 'empty'=>array(' ')));?>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                </div>                
                <div class="col-md-10 pull-right">
                    <br/><br/><br/>
                    <div class="form-group">
                        <?php
                            $requestSubmit=array(
                                'class'=>'btn btn-md btn-primary',
                                'escape' => FALSE,
                                'type' => 'submit',);
                            echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Save'), $requestSubmit);
                        ?>        
                    </div>
                </div>
            
            
            <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">        
                          <div class="modal-header">
                              <input id="_unique" type="hidden" name="_unique" value="<?php echo $user['User']['unique'];?>" />
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="passwordModalLabel"><i class="glyphicon glyphicon-lock"></i> <?php echo __('Change your password');?></h4>
                          </div>
                      <div class="password-success-content hidden">
                          <div class="modal-body alert-success clearfix">
                              <h5> <i class="glyphicon glyphicon-ok"></i> <?php echo __('Password has been updated successfully.');?></h5>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
                          </div>
                      </div>
                          <div class="password-toggle-content">
                          <div class="modal-body clearfix"><br/>
                              <p class="col-lg-12">
                                <?php echo __('Please provide your old password and enter a new pasword twice'); ?><br/>
                                <span class="length-required"><?php echo __('Password should be (6-24) characters.'); ?></span>
                              </p><br/><br/><br/>
                              <div class="col-lg-12">
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="password-old" name="password" class="form-control" aria-describedby="password" autocomplete="off" placeholder="<?php echo __('old password'); ?>" type="password"/> <br/>
                                    </div><br/>
                                    <span class="match-required"><?php echo __('Provide new password twice.'); ?></span>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="container-password1"><i class="glyphicon glyphicon-repeat"></i></span>
                                        <input id="password1" name="password1" class="form-control" aria-describedby="password1" autocomplete="off" placeholder="<?php echo __('new password'); ?>" type="password"/> <br/>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="container-password2"><i class="glyphicon glyphicon-repeat"></i></span>
                                        <input id="password2" name="password2" class="form-control" aria-describedby="password2" autocomplete="off" placeholder="<?php echo __('new password again'); ?>" type="password"/> <br/>
                                    </div>

                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                              <div class=" error-container pull-left text-left">
                                  <span class="error error-old-invalid hidden"><i class="glyphicon glyphicon-remove"></i> <?php echo __('Provided password is not valid.');?><br/></span>
                                  <span class="error error-oldPassword hidden"><?php echo __('Password should be (6-24) characters.');?><br/></span>
                                  <span class="error error-password hidden"><?php echo __('New password should be (6-24) characters.');?><br/></span>
                                  <span class="error error-match hidden"><?php echo __('Both fields should have same password.');?><br/></span>
                              </div>
                              <div class="ajax-spinner-container">
                              <div class="ajax-spinner"></div>
                              </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>
                            <button type="button" class="btn btn-primary" onclick="reuqestNewPassword();"><?php echo __('Save changes');?></button>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
        </div>
    </section>
</main>















<main id="main" class="site-main" role="main">
    <section id="user-editor">

        <div class="page-content clearfix">
            
 
            <div class="col-lg-12">
            </div>
        </div>
    </section>
</main>