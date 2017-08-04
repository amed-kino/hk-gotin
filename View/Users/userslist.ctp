<?php
if ($this->Session->check('Auth.Acl')){
    $Acl=$this->Session->read('Auth.Acl');   
}else{
    $Acl = null;
}
Configure::load('links');
$links = Configure::read('HK.links');
?>

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
                    <div class="description">
                        <?php echo $letter;?>
                     <?php echo __('%s Results','('.sizeof($users).')');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 users-letters">
                <?php echo $this->element('users/alphabit_board');?>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
            <input id="changeRank" type="hidden" name="changeRank" value="<?php echo $links['changeRank'];?>" />
        </header>
        
        <div class="page-body users-list-body clearfix">
            
            <div class="page-content clearfix">
                    <table class="table table-striped table-bordered table-hover no-footer">
                        <thead>
                            <tr role="row">
                                <th><?php echo __('Name');?></th>
                                <th><?php echo __('username');?></th>
                                <th><?php echo __('counters');?></th>
                                <th><?php echo __('rank');?></th>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($users as $user) :
                            if ($user['User']['active'] =='no'){$active = 'no';}else{$active = 'yes';}
                        ?>

                        <tr>
                            <td><?php echo $user['User']['name'];?> <?php echo $active == 'no'? '<i class="glyphicon glyphicon-lock"></i>': '';?></td>
                            <td><?php echo $user['User']['username'];?></td>
                            <td>
                                <span class="counter"><i class="glyphicon glyphicon-artist"></i> <?php echo $user['User']['artist_counter'];?> </span>
                                <span class="counter"><i class="glyphicon glyphicon-album"></i> <?php echo $user['User']['album_counter'];?> </span>
                                <span class="counter"><i class="glyphicon glyphicon-lyric"></i> <?php echo $user['User']['lyric_counter'];?> </span>
                            </td>
                            <td class="rank">
                                <?php 
                                    $rank  = 6-($user['User']['group_id'])*1;
                                    $group = 6-($this->Session->read('Auth.User.group_id'))*1;
                                    echo $this->element('rank',array('rank' => $rank,'unique' =>$user['User']['unique'],'group' => $group));
                                ?>
                            </td>
                            <td class="">
                                <div class="btn-group">
                                <button class="btn btn-sm btn-action dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right">  
                                    <li><?php echo $this->Html->link('<i class="glyphicon glyphicon-user"></i> '.__('View'), array('conroller'=>'users','action' => 'profile', $user['User']['unique']),array('escape' =>false)); ?></li>
                                    <li><a class="disabled" href="#"><i class="glyphicon glyphicon-pencil"></i> <?php echo __('Edit');?></a></li>
                                    <li><a class="disabled" href="#"><i class="glyphicon glyphicon-remove declined"></i> <?php echo __('Delete');?></a></li>
                                    <?php if($Acl['User']['3'] == true):?>
                                    <li><a class="disabled" href="#"><i class="glyphicon glyphicon-lock declined"></i> <?php echo __('Inactive');?></a></li>
                                    <?php endif;?>

                                </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>            
        </div>
    </section>
</main>
 

