<div id="driver">
    <ol class="breadcrumb">
        <li class="active"><?php echo __('Users');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="users">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-user"></i></div>
                <div class="text-container">
			<div class="info">
	                    <div class="title"><?php echo __('Users'); ?></div>
			</div>
                    
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body users-body clearfix">
            <br/><br/>
            <ul>
               <?php foreach ($users as $user): $user = $user['User'];?>
                
                <li>
                    <?php 
                        echo $this->Html->link($user['name'],array('controller' => 'users','action' => 'profile', $user['unique'])),                                
                        ' - ', __('Lyrics'),
                        ' (',$user['lyric_counter'],')',
                        ' ', __('Albums'),
                        ' (',$user['album_counter'],')',
                        ' ', __('Artists'),                                
                        ' (',$user['artist_counter'],')';
                                
                    ?>
                </li>
                
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</main>