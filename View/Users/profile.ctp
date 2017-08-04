<?php
$image = 'nenas.jpg';

if ($user['User']['social_network']=='yes'){
    $image = $user['User']['social_network_picture'];
}

if ($user['User']['image']!=null){
    $image = $this->Html->url('/', true).'wene/endam/'.$user['User']['image'];
}

echo $this->Html->meta(
        array(
            'name' => 'description', 
            'content' => 'Rûpla endamê civaka HKyê '.
                $user['User']['name'].
                ' Ji '.
                date("d-m-Y",strtotime($user['User']['created'])).
                ' de endam e. Ji çalakiyan '.
                $user['User']['artist_counter'].
                ' Hunermend, '.
                $user['User']['album_counter'].
                ' Berhem û '.
                $user['User']['lyric_counter'].
                ' Stran ta niha daxistin e.'
            ),
        '',
        array('inline'=>false)
    );
echo $this->Html->meta(array('name' => 'author', 'content' => ''),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:title', 'content' => 'Endamên civaka Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:site_name', 'content' => 'Hunera Kurdî'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:type', 'content' => 'article'),'',array('inline'=>false));
echo $this->Html->meta(array('property' => 'og:image', 'content' => $image),'',array('inline'=>false));
?>
<div id="driver">
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Users'),array('controller'=>'users','action' => 'index'));?></li>
    <li class="active"><?php echo $user['User']['name']; ?></li>
</ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="user-profile">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="profile-details clearfix">
                    <?php echo $this->Element('users/profile_entry');?>
                </div>
            </div>
                        
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body property-body clearfix">
            <div class="user-statics pull-right">
                <i class="glyphicon glyphicon-artist"></i> <?php echo __('%s artists','('.$user['User']['artist_counter'].')');?>
                <i class="glyphicon glyphicon-album"></i> <?php echo __('%s albums','('.$user['User']['album_counter'].')');?>
                <i class="glyphicon glyphicon-lyric"></i> <?php echo __('%s lyrics','('.$user['User']['lyric_counter'].')');?>
            </div>
            <p>
                <?php echo $this->Html->link( '<i class="glyphicon glyphicon-list"></i> '.__('Property review'), array('controller' => 'users', 'action' => 'property', $user['User']['unique']),array('escape' => false,'class' => 'btn btn-default'));?>
            </p>
            
            <hr />
            <div class="stock">
                <div class="review">
                    <div class="upeer-block col-lg-12">
                        <div class="artists col-lg-6  row clearfix">                                   
                            <?php if ($userArtistsLatest==null):?>
                                <div class="title"><i class="glyphicon glyphicon-artist"></i> <?php echo __('No artists yet.');?></div>
                           <?php else: ?>

                                <div class="title"><i class="glyphicon glyphicon-artist"></i>  <?php echo __('Latest Artists');?></div>
                                <table>
                                <?php foreach ($userArtistsLatest as $latestArtist):?>
                                    <tr>
                                        <td class="artist-name"><?php echo $this->Html->link($latestArtist['Artist']['name'],array('controller'=>'artists','action'=>'index',$latestArtist['Artist']['unique']),array('class'=>'','title'=>$this->Time->timeAgoInWords($latestArtist['Artist']['created'])));?></td>
                                        <td><?php echo __('Albums');?> (<?php echo $latestArtist['Artist']['album_counter'];?>)</td>
                                        <td><?php echo __('Lyrics');?> (<?php echo $latestArtist['Artist']['lyric_counter'];?>)</td>
                                    </tr>
                                <?php endforeach;?>
                                </table>
                                <div class="clearfix"></div>
                            <?php if ($user['User']['artist_counter']>10) echo $this->Html->link(__('Show all %s\'s artists',$user['User']['name']).'»',array('controller'=>'users','action'=>'property','artists',$user['User']['unique']),array('class'=>'see-total btn btn-md btn-default'));?>
                            <?php endif; ?>
                        </div>
                        <div class="albums col-lg-6 row clearfix">

                            <?php if ($userAlbumsLatest==null):?>
                                <div class="title"><i class="glyphicon glyphicon-album"></i> <?php echo __('No albums yet.');?></div>
                           <?php else: ?>

                                <div class="title"><i class="glyphicon glyphicon-album"></i> <?php echo __('Latest Albums');?></div>
                                <table>
                                <?php foreach ($userAlbumsLatest as $latestalbums):?>
                                    <tr>
                                        <td class="album-title"><?php echo $this->Html->link($latestalbums['Album']['title'].' '.$this->HK->albumYear($latestalbums['Album']['year']),array('controller'=>'albums','action'=>'index',$latestalbums['Album']['unique']),array('class'=>'','title'=>$this->Time->timeAgoInWords($latestalbums['Album']['created'])));?></td>
                                        <td>(<?php echo $latestalbums['Album']['lyric_counter'];?>) <?php echo __('Lyrics');?> </td>
                                        <td class="artist-name"><?php echo $this->Html->link($latestalbums['Artist']['name'],array('controller'=>'artists','action'=>'index',$latestalbums['Artist']['unique']),array('class'=>''));?></td>                                                

                                    </tr>
                                <?php endforeach;?>
                                </table>
                                
                                <?php if ($user['User']['album_counter']>10)echo $this->Html->link(__('Show all %s\'s albums',$user['User']['name']).' »',array('controller'=>'users','action'=>'property','albums',$user['User']['unique']),array('class'=>'see-total btn btn-md btn-default'));?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="lyrics lower-block col-lg-12">

                        <div class="lyrics-latest col-lg-6 row clearfix">
                            <?php if ($userLyricsLatest==null):?>
                                <div class="title"><i class="glyphicon glyphicon-lyric"></i> <?php echo __('No lyrics yet.');?></div>
                           <?php else: ?>

                                <div class="title"><i class="glyphicon glyphicon-lyric"></i> <?php echo __('Latest Lyrics');?></div>
                                <table>
                                <?php foreach ($userLyricsLatest as $latestlyrics):?>
                                    <tr>
                                        <td class="block">
                                            <span class="lyric-title">
                                                <?php echo $this->Html->link($latestlyrics['Lyric']['title'],array('controller'=>'lyrics','action'=>'index',$latestlyrics['Lyric']['unique']),array('class'=>'','title'=>$this->Time->timeAgoInWords($latestlyrics['Lyric']['created'])));?> - <span class="lyric-created"><?php echo $this->Time->timeAgoInWords($latestlyrics['Lyric']['created']);?></span><br/>
                                            </span>
                                            <span class="further-info">
                                                <i class="glyphicon glyphicon-album"></i> <?php echo $this->Html->link($latestlyrics['Album']['title'].' '.$this->HK->albumYear($latestlyrics['Album']['year']).' - ',array('controller'=>'albums','action'=>'index',$latestlyrics['Album']['unique']));?>
                                                <i class="glyphicon glyphicon-artist"></i>  <?php echo $this->Html->link($latestlyrics['Artist']['name'],array('controller'=>'artists','action'=>'index',$latestlyrics['Artist']['unique']),array('class'=>''));?>
                                                <i class="glyphicon glyphicon-eye-open"></i> <?php echo $latestlyrics['Lyric']['views'];?>
                                            </span>
                                        </td>

                                    </tr>
                                <?php endforeach;?>
                                </table>
                                <div class="clearfix"></div>
                            <?php endif; ?>
                        </div>

                        <div class="lyrics-popular col-lg-6 row clearfix">
                            <?php if ($userLyricsPopular==null):?>
                                <div class="title"><i class="glyphicon glyphicon-lyric"></i> <?php echo __('No lyrics yet.');?></div>
                           <?php else: ?>

                                <div class="title"><i class="glyphicon glyphicon-lyric"></i> <?php echo __('Popular Lyrics');?></div>
                                <table>
                                <?php foreach ($userLyricsPopular as $popularllyrics):?>
                                    <tr>
                                        <td class="block">
                                            <span class="lyric-title">
                                                <?php echo $this->Html->link($popularllyrics['Lyric']['title'],array('controller'=>'lyrics','action'=>'index',$popularllyrics['Lyric']['unique']),array('class'=>'','title'=>$this->Time->timeAgoInWords($latestlyrics['Lyric']['created'])));?> - <span class="lyric-created"><?php echo $this->Time->timeAgoInWords($popularllyrics['Lyric']['created']);?></span><br/>
                                            </span>
                                            <span class="further-info">
                                                <i class="glyphicon glyphicon-album"></i> <?php echo $this->Html->link($popularllyrics['Album']['title'].' '.$this->HK->albumYear($popularllyrics['Album']['year']).' - ',array('controller'=>'albums','action'=>'index',$popularllyrics['Album']['unique']));?>
                                                <i class="glyphicon glyphicon-artist"></i> <?php echo $this->Html->link($popularllyrics['Artist']['name'],array('controller'=>'artists','action'=>'index',$popularllyrics['Artist']['unique']),array('class'=>''));?>
                                                <i class="glyphicon glyphicon-eye-open"></i> <?php echo $popularllyrics['Lyric']['views'];?>
                                            </span>
                                        </td>

                                    </tr>
                                <?php endforeach;?>
                                </table>
                               
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($user['User']['lyric_counter']>10) echo $this->Html->link(__('Show all %s\'s lyrics',$user['User']['name']).' »',array('controller'=>'users','action'=>'property','lyrics',$user['User']['unique']),array('class'=>'see-total btn btn-md btn-default'));?>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>