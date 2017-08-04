<nav class="navbar navbar-inverse navbar-static-top main-navigation" role="navigation" id="site_navigation">
    <div class="main-header">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only"><?php echo __('Toggle navigation');?></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <div id="logo">
                <div class="logo-text">
                    <a href="https://hunerakurdi.com" title="huneraKurdi.com">HK</a></div>
            </div>
        </div>
        <div class="collapse navbar-collapse">
            <ul id="menu-main" class="nav nav-tabs navbar-nav">
                <?php echo $this->HK->menuItemCreator('Home',array('controller' => 'artists', 'action' => 'index'));?>
                <?php echo $this->HK->menuItemCreator('Requests',array('controller' => 'requests', 'action' => 'index'));?>
                <?php echo $this->HK->menuItemCreator('About',array('controller' => 'pages', 'action' => 'about'));?>
                <?php echo $this->HK->menuItemCreator('Contact',array('controller' => 'pages', 'action' => 'contact'));?>
            </ul>
            <div class="navbar-right">
                <?php if(!$this->Session->check('Auth.User')):?>
                <ul id="menu-login" class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="/endam/tekeve" data-toggle="dropdown" id="navLogin">
                            <i class="glyphicon glyphicon-user"></i> 
                                <?php echo __('Users');?> 
                            <b class="caret"></b>
                        </a>
                           <?php echo $this->element('users/menu_login');?>
                    </li>
                </ul>
                
                    <?php else:?>
                
                    <?php
                        $barUsername = $this->Session->read('Auth.User.name');
                    ?>
                
                <ul id="users-nav" class="nav navbar-nav">   
                   
                    <?php
                        // echo $this->element('users/menu_approvals');
                    ?>
                    
                    <?php
                        //echo $this->element('users/menu_notes');
                    ?>
                            
                    <?php
                        //echo $this->element('users/menu_notifications');
                    ?>

                    <li class="dropdown"  id="menu-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $barUsername;?>">
                            <b class="caret"></b>
                           <?php
                            echo $this->HK->scissors($barUsername,'username');
                            ?>
                        </a>
                            <?php echo $this->element('users/menu_user');?>
                    </li>
                   
                </ul>
                <?php endif;?> 
                
                
            </div>
        <div class="search-form">
            <?php echo $this->element('find/search_bar');?>
        </div>

<?php echo $this->element('letters_board');?>
        </div>
    </div>
</nav>
