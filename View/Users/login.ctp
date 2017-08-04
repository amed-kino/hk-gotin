<div id="login">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('Login');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="login">
        <header class="page-header login-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-user"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('Login'); ?></div>
                    
                    <div class="tips">
                    
                        <?php echo __('You can login with your Email adress or username,you can also login with your facebook account.');?> <br/>
                        <span class="forgot-link"><?php echo $this->Html->link( __('Forgot password?'),array('controller'=>'users','action'=>'recovery'));?></span>
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body login-body clearfix">

            
            
            
            <?php echo $this->Form->create('User',array('class'=>'form-horizontal','role'=>'form','inputDefaults'=>array('label'=>false)));?>
            <fieldset class="col-lg-10 col-md-12">
            <div class="control-group">
              <label class="control-label" for="username"><?php echo __('Username');?></label><span class="username-ajax-loader"></span><span class="username-ajax-info"></span>
              <div class="controls">
                  
                <?php echo $this->Form->input('username',array('label'=>false,'class'=>'form-control','placeholder'=>'Username','required'));?>
                  <p id="username-help-block" class="username-help-block"></p>
              </div>
            </div>
            <div class="control-group password">
              <label class="control-label" for="password"><?php echo __('Password');?></label><span class="password-ajax-info"></span>
              <div class="controls">
                <?php echo $this->Form->password('password',array('label'=>false,'class'=>'form-control','placeholder'=>'Password','required'));?>
                <p id="password-help-block" class="password-help-block"></p>
              </div>
            </div>  
                <br/>
                        <div class="form-group">
                            <div class="col-sm-12 controls">
                                <?php
                                    $requestSubmit=array(
                                        'class'=>'btn btn-md btn-primary',
                                        'escape' => FALSE,
                                        'type' => 'submit',);
                                    echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Login'), $requestSubmit);
                                echo ' ', $this->Html->link('<i class="glyphicon glyphicon-facebook"></i> '.__('Login with Facebook'),array('action'=>'social_login', 'Facebook'),array('class' => 'btn btn-primary','escape' => false));
                                        
                                        
                                    ?>
                                      

                            </div>
                        </div>
                                    <div class="col-md-12 control">
                                        <div class="signup-link"><?php echo __('Don\'t have an account!'),' ',$this->Html->link( __('Sign Up Here'),array('controller'=>'users','action'=>'signup'));?></div>
                                    </div>
                           <?php echo $this->Form->end();?>  
          </fieldset>
         
        </div>
    </section>
</main>