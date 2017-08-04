<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo $this->Html->link(__('Users'),array('controller' => 'users', 'action' => 'index'),array());?></li>
        <li><?php echo $this->Html->link(__('List all users'),array('controller' => 'users', 'action' => 'userslist'),array());?></li>
        <li class="active"><?php echo $letter;?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="users-list">
        <header class="page-header clearfix">
            <div class="main-info clearfix">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-user"></i></div>
                <div class="text-container">
                    <div class="title"><?php echo __('Users');?></div>
                    <div class="description"><?php echo $letter;?></div>
                </div>
            </div>
            <div class="col-lg-12 users-letters">
                <?php echo $this->element('users/alphabit_board');?>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body users-list-body clearfix">
            <?php echo __('There is no matched users to %s','<em>'.$letter.'</em>');?>
        </div>
    </section>
</main>