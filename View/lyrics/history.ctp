<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link($letter,array('controller'=>'artists','action'=>'index',$letter),array());?></li>
    <li><?php echo $this->Html->link($lyric['Artist']['name'],array('controller'=>'artists','action'=>'index',$lyric['Artist']['unique']),array());?></li>
    <li><?php echo $this->Html->link($lyric['Album']['title'].' ('.$lyric['Album']['year'].')',array('controller'=>'albums','action'=>'index',$lyric['Album']['unique']),array());?></li>            
    <li><?php echo $this->Html->link($lyric['Lyric']['title'],array('controller'=>'lyrics','action'=>'index',$lyric['Lyric']['unique']),array());?></li>            
    <li class="active"><?php echo  __('Edit history');?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="history-edits">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix"><i class="glyphicon glyphicon-lyric-recent-edit"></i></div>
                <div class="text-container">
                    <div class="info">
                        <div class="title">
                            <?php echo __('Edit history');echo $editsParam['editsCounter']? ' <span class="counter">('.($editsParam['editsCounter']-1).')</span>':''; ?><br/>
                            <?php echo $this->Html->link($lyric['Lyric']['title'],array('controller'=>'lyrics','action'=>'index',$lyric['Lyric']['unique']));?> - 
                            <?php echo $this->Html->link($lyric['Artist']['name'],array('controller'=>'artists','action'=>'index',$lyric['Artist']['unique']));?>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body clearfix">
            <div class="pull-right">
                <i class="glyphicon glyphicon-lyric-document accepted"></i> <span class="accepted description"><?php echo __('accepted');?></span>
                <i class="glyphicon glyphicon-lyric-document pending"></i>  <span class="pending description"><?php echo __('pending');?></span>
                <i class="glyphicon glyphicon-lyric-document declined"></i> <span class="declined description"><?php echo __('declined');?></span>
            </div>
                    <?php if ($editsParam['editsCounter']==0): ?>
                    <div class="results col-lg-12">
                        
                        <p class="not-found"><?php echo __('There is no available edits for this lyric.');?></p>
                        
                    </div>
                    
                        
                    <?php  else: ?>
                    
                    <div class="results col-lg-12">
                        <p><?php echo __('This lyric has been edited for %s times.','<strong>'.($editsParam['editsCounter']-1).'</strong>');?></p>
                        <p><?php echo __('Last edit was at %s','<em>'.$this->Time->format('F jS, Y h:i A',$editsParam['lastCreated'],null).'</em>');?></p>
                        <p><?php echo __('You can follow the changes through down panels.');?>:</p><br/>
                    </div>
                    <div class="panel-group col-lg-12" id="accordion">
 
                    <?php
                    foreach ($edits as $key => $edited):
                        
                        if ($edited['EditLyric']['type'] == 'orginal'){
                            
                            $icon='<i class="glyphicon glyphicon-lyric '.$edited['EditLyric']['status'].'"></i>';
                            
                        }else{

                            $icon='<i class="glyphicon glyphicon-lyric-document '.$edited['EditLyric']['status'].'"></i>';
                        
                        }
                        
                        if ($currentId==$edited['EditLyric']['id']){
                            
                            $selectedClass = ' selected';
                            $aria='aria-expanded="true"';
                            $style='style=""';
                            $class='calss=""';
                            $classDiv='class="panel-collapse collapse in"';
                            
                        }else{
                            
                            $selectedClass = '';
                            $aria='aria-expanded="false"';                            
                            $style='style="height: 0px;"';
                            $class='class="collapsed"';
                            $classDiv='class="panel-collapse collapse"';
                            
                        }
                    ?>
                        <div class="panel panel-recent-edit<?php echo $selectedClass;?>">
                            <div class="panel-heading">
                                <p class="panel-title">
                                    
                                <?php if ($action == true):?>
                                    
                                    
                                        <div class="history-action btn-group">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="glyphicon glyphicon-pushpin"></i>
                                            </a>
                                            <ul class="dropdown-menu slidedown">
                                                <li>
                                                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric-document accepted"></i> '.__('accept'),array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique'],'accept' => $edited['EditLyric']['id']),array('escape' => false));?>
                                                </li>
                                                <li>
                                                    <?php echo $this->Html->link('<i class="glyphicon glyphicon-lyric-document declined"></i> '.__('decline'),array('controller'=>'lyrics','action'=>'history',$lyric['Lyric']['unique'],'decline' => $edited['EditLyric']['id']),array('escape' => false));?>
                                                </li>
                                            </ul>
                                        </div>
                               
                                <?php endif;?>
                                
                                    
                                    <span class="link">
                                        <a <?php echo $class;?> <?php echo $aria;?> data-toggle="collapse" data-parent="#accordion" href="#edit-block-<?php echo $edited['EditLyric']['id'];?>"><span class="status-icon"><?php echo $icon;?></span> <?php echo $key?'#'.$key:'';?> <?php echo $edited['EditLyric']['title'];?> <?php echo $lyric['Album']['title'];?> (<?php echo $lyric['Album']['year'];?>) <?php echo $lyric['Artist']['name'];?></a>
                                        <?php echo ($edited['EditLyric']['type']=='current')? '<span class="current">('.__('Current').')</span>':'';?>
                                    </span>
                                    <span class="meta">
                                           <?php echo $this->Html->link($edited['User']['name'],array('controller'=>'users','action'=>'profile',$edited['User']['unique']));?>   <i class="glyphicon glyphicon-user small"></i><br/>
                                           <?php echo $this->Time->format('d-m-Y h:i A', $edited['EditLyric']['created'],null); ?>    <i class="glyphicon glyphicon-time small"></i>  
                                    </span>
                                </p>
                            </div>       
                            <div <?php echo $style;?> <?php echo $aria;?>  id="edit-block-<?php echo $edited['EditLyric']['id'];?>" <?php echo $classDiv;?>>
                                <div class="panel-body">
                                    <p>
                                        <?php echo __('Artist'),': ',$lyric['Artist']['name'];?> ||
                                        <?php echo __('Album'),': ',$lyric['Album']['title'];?> (<?php echo $lyric['Album']['year'];?>) ||
                                        <?php echo __('Title'),': ',$edited['EditLyric']['title'];?><br/>
                                    </p>
                                    <p>
                                        <?php echo __('Writer'),': ',$edited['EditLyric']['writer'];?> ||
                                        <?php echo __('Composer'),': ',$edited['EditLyric']['composer'];?> ||
                                        <?php echo __('echelon'),': ',$edited['EditLyric']['echelon'];?> <br/>
                                    </p>
                                    <hr/>
                                  <?php echo $edited['EditLyric']['text'];?>  
                                    <hr/>
                                  <?php echo __('Source'),': ',$edited['EditLyric']['source'];?>  
                                    <div class="clearfix"></div>
                                </div><div class="clearfix"></div>
                            </div>
                        </div>
                        <?php endforeach;?>                        
                        
                    </div>
                    <?php endif;?>
                
        </div>
    </section>
</main>