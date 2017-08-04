<?php
echo $this->Html->script('hk-signup.js', array('block' => 'scriptBottom'));
echo $this->Html->css('hk.users.panels', array('block' => 'css'));

echo $this->Html->meta(array('name' => 'description', 'content' => 'Her kes dikare bibe endam û gotinên strana bi azadî pareveke. Civaka HuneraKurdî civakeke azad e, her kurdek bi zimanê xwe zanibe binvîse dikare bi navê xwe li ser civakê stranan daxe û paraveke.'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Bibe endamê HKyê'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => FULL_BASE_URL.'/wene/og-user-logo.jpg'),'',array('inline'=>false));
?>

<div id="driver">
    <ol class="breadcrumb">
        <li class="active">
            <i class="glyphicon glyphicon-user"></i>
            <?php echo __('New user');?>
        </li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
<section id="signup">
    <header class="page-header signup-header clearfix">
        <div class="instruction">
            <h4><?php echo __('Signing in is easy. You can either:');?></h4>
            <p>
                <?php echo __('Provide a username and your Email and start imediatly to add your own lyrics.');?><br/>
                <?php echo __('Register with your social account.');?>
            </p>
            <ul class="required">
                <li>
                   <?php echo __('Username can contain any letters or numbers, without spaces. Between (4-24) letters.'); ?>
                </li>
                <li>
                   <?php echo __('Username starts with letter and undercore (_) only allowed.'); ?>
                </li>
                <li>
                   <?php echo __('Email address must be correct.'); ?>
                </li>
                <li>
                   <?php echo __('Password is between (6-24) letters.'); ?>
                </li>
            </ul>
        </div>
        <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
    </header>
        
    <div class="page-body signup-body clearfix">
        <div class="social-login col-xs-12">
            <?php echo ' ', $this->Html->link('<i class="glyphicon glyphicon-facebook"></i> '.__('Login with Facebook'),array('controller' => 'users','action'=>'social_login', 'Facebook'),array('class' => 'btn btn-primary','escape' => false));?>
            <hr />
        </div>
        
        <div class="col-xs-12">
            <h4><?php echo __('New user');?></h4>
            <?php echo $this->Form->create('User',array('class'=>'form-horizontal','role'=>'form','inputDefaults'=>array('label'=>false)));?>
            <fieldset>

                <div class="col-xs-12 clearfix">
                    <div class="username">
                        <div class="ajax col-xs-12">&nbsp;
                            <div class="ajax-loader"></div>
                            <div class="caution invalid">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __('Please provide valid username.');?>
                            </div>
                            <div class="caution not-available">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __("Username '%s' is already taken. Try another username.",'<span class="username-pointer">Undifiend</span>');?>
                            </div>
                            <div class="caution available">
                                <i class="glyphicon glyphicon-ok"></i>
                                <?php echo __("Username '%s' is available.",'<span class="username-pointer">Undifiend</span>');?>
                            </div>
                        </div>
                        <?php echo $this->Form->input('username',array(
                                'before'=> '<div class="form-group col-lg-8 pull-left"><div class="input-group"><div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>',
                                'after' => '</div></div>',
                                'div' => true,
                                'class'=>'form-control',
                                'placeholder'=>__('Username'),'required' => false)
                            );
                        ?>
                    </div>





                    <div class="email">
                        <div class="ajax col-xs-12">&nbsp;
                            <div class="ajax-loader"></div>
                            <div class="caution invalid">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __('Please provide a valid Email.');?>
                            </div>
                            <div class="caution not-available">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __("Email '%s' is already registerd. Try another email.",'<span class="email-pointer">Undifiend</span>');?>
                            </div>
                            <div class="caution available">
                                <i class="glyphicon glyphicon-ok"></i>
                                <?php echo __("Email '%s' is available.",'<span class="email-pointer">Undifiend</span>');?>
                            </div>
                        </div>
                        <?php echo $this->Form->input('email',array(
                                'before'=> '<div class="form-group col-lg-8 pull-left"><div class="input-group"><div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>',
                                'after' => '</div></div>',
                                'div' => true,
                                'class'=>'form-control',
                                'placeholder'=>__('Email'),'required' => false)
                            );
                        ?>
                    </div>


                    <div class="password">
                        <div class="ajax col-xs-12">&nbsp;

                            <div class="caution balnk">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __("Please provide valid password.");?>
                            </div>
                            <div class="caution length">
                                <i class="glyphicon glyphicon-remove"></i>
                                <?php echo __("Password is between (6-24) letters.");?>
                            </div>
                            <div class="caution invalid-confirmation">

                                <?php echo __('Please confirm password.');?>
                            </div>
                            <div class="caution valid-confirmation">
                                <i class="glyphicon glyphicon-ok"></i>
                                <?php echo __('Password confirmation is done.');?>
                            </div>
                        </div>
                        <?php echo $this->Form->input('password',array('type' => 'password',
                                'before'=> '<div class="form-group col-lg-8 pull-left"><div class="input-group"><div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>',
                                'after' => '</div></div>',
                                'div' => true,
                                'class'=>'form-control',
                                'placeholder'=>__('Password'),'required' => false)
                            );
                        ?>
                        <?php echo $this->Form->input('password_confirm',array('type' => 'password',
                                'before'=> '<div class="form-group col-lg-8 pull-left"><div class="input-group"><div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>',
                                'after' => '</div></div>',
                                'div' => true,
                                'class'=>'form-control',
                                'placeholder'=>__('Password (Confirm)'),'required' => false)
                            );
                        ?>
                    </div>
                    </div>
                <div class="signup-actions col-xs-12 clearfix">
                    <div class="col-xs-12 controls">
                        <?php
                            $requestSubmit=array(
                                'id'=>'submition',
                                'class'=>'btn btn-md btn-success',
                                'escape' => FALSE,
                                'type' => 'submit',);
                            echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Signup'), $requestSubmit);
                        ?>     

                    </div>
                    <?php echo $this->Form->end();?>  
                </div>
            </fieldset>
        </div>
    </div>
</section>
</main>