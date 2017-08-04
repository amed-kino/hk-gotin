<?php
Configure::load('links');
$links = Configure::read('HK.links');
$addAlbum=$this->Html->url(array('controller' => 'albums','action' => 'add'),true);
$addScript='';
$artist_unique='';
$data=$this->data;
if (!empty($data)){
    if ($data['artist_unique']!=null){
    $artist_unique=$data['artist_unique'];
}else{
    $artist_unique='';
}
if ($data['artist_unique'] && $data['album_unique']){
    $addScript=
            
              "$('#lyric-board').css('display','block'); "
            . "$('#artist-board').css('display','none');"

            . "$('#hidden-artist-unique').val('".$c_artist_unique."');"
            . "$('#hidden-album-unique').val('".$c_album_unique."');"
            . "$('#hidden-artist-name').val('".$c_artist_name."');"
            . "$('#hidden-album-title').val('".$c_album_title."');"

            . "$('.detail-artist-name').html('".$c_artist_name."');"
            . "$('.detail-album-title').html('".$c_album_title."');";  
    
}else{
    $addScript='';
}
}


$this->Html->scriptBlock("

function setDetails(){
    if (!$('#album-name option:selected').val() || $('#album-name option:selected').val()==' ' || !$('#artist-name option:selected').val()){
        $('#artist-board .error').html('<span class=\"text-danger\"><i class=\"glyphicon glyphicon-remove\"> </i>".__('Please Select Artist and Album to complete.')."</span>').hide().fadeIn();
    }else{     
        var artistUnique,albumUnique,artistName,albumTitle;
        
        artistUnique = $('#artist-name option:selected').val();
        albumUnique =  $('#album-name option:selected').val();
        
        artistName = $('#artist-name option:selected').text();
        albumTitle = $('#album-name option:selected').text();
        

            $('#hidden-artist-unique').val(artistUnique);
            $('#hidden-album-unique').val(albumUnique);
            $('#hidden-artist-name').val(artistName);
            $('#hidden-album-title').val(albumTitle);        
        
        $('.detail-artist-name').html(artistName);
        $('.detail-album-title').html(albumTitle);   
        $('#artist-board .error').html('');
        $('#artist-board').css('display','none').show().fadeOut(function (){\$('#lyric-board').css('display','block').hide().fadeIn(); }); 
        
        $('.error-message').html(' ');
        
    }
    }
function resetDetails(){
    $('#artist-board .error').html('');
    $('#lyric-board').css('display','visible').show().fadeOut(function (){\$('#artist-board').css('display','block').hide().fadeIn(); }); 
    return false;        
}
$('document').ready(function(){
    ".$addScript."
    $('#artist-name').change(function(){
    if ($('#artist-name option:selected').val()!=''){
        $('#artist-board .error').html('');
        $('.artist-name-ajax').css('display','inline-block');
        $.ajax({
        url: '".$links['albumsList']."/'+$('#artist-name').val(),
        dataType: 'json',
            success: function(data)
            { 

                $('.album-section-content').css('display','none'); 
                $('.artist-name-ajax').css('display','none');
                $('#album-section').css('display','none');
                
                $('#artist-section .help-block').html('');
                $('#album-section .help-block').html('');

                if (data.artist==false){
                    $('#artist-name option:selected').val(' ');
                    $('#album-name option:selected').val(' ');
                   $('#artist-section .help-block').html('<span class=\"text-danger\"><i class=\"glyphicon glyphicon-remove\"> </i> ".__('Invalid artist.')."</span>');
                }else{   
                    $('#album-section').css('display','inline-block');
                    if (data.albums==false){
                        $('#artist-name option:selected').val(' ');
                        $('#album-name option:selected').val(' ');
                        $('#album-section .help-block').html('<span class=\"text-danger\"><i class=\"glyphicon glyphicon-remove\"> </i> ".__('There is no albums to show.')." <a href=\"".$links['addAlbum']."\">".__('Add new album')."</a></span>');
                    }else{

                      if (data.data){
                        var arr = [];
                        $.each(data.data,function(key,value){
                            arr.push('<option value=\"'+key+'\">'+value+'</option>');
                        });
                        var arrval =arr.join('');
                        
                        $('#album-section').css('display','inline-block'); 
                        $('.album-section-content').css('display','inline'); 
                        $('#album-name').html(arrval).hide().fadeIn('fast');
                        this.affirmation=' s ';
                      }else{
                          alert('".__('Error fetching array.')."');
                      }
                    }
                }


            },
            error: function () {
                $('#artist-name option:selected').val('');
                $('#album-name option:selected').val('');
                if ($('#LyricArtistId').val()!=''){
                 alert('Daxwaze te bi serî nabe.\\nPêvegihaştina te ya întirnêtê ne durust e.');
                 
             }

                 $('.album-ajax-loader').css('display','none');

            }
        });
        
   } });
    
});
",array('inline'=>FALSE));
?>

<div id="driver">
    <ol class="breadcrumb">
        <li><?php echo __('Add');?></li>
        <li class="active"><?php echo __('Lyric');?></li>
    </ol>
</div>
<main id="main" class="site-main" role="main">
    <section id="add-lyric">
        <header class="page-header clearfix">
            <div class="main-info">
                <div class="icon-container clearfix">
                    <i class="glyphicon glyphicon-lyric"></i>
                </div>
                <div class="text-container">
                    <div class="details">
                        <?php echo __('New lyric'); ?><br/>
                        <span class="detail-artist-name">&nbsp;</span><br/>
                        <span class="detail-album-title">&nbsp;</span>
                    </div>
                </div>
                <div class="action-content pull-right">
                    <button class="btn btn-primary btn-sm" onclick="resetDetails()">
                        <i class="glyphicon glyphicon-repeat"></i> <?php echo __('Change details');?>
                    </button>
                </div>
            </div>
            <?php echo $this->Session->flash('flashError',array('element'=>"flashError"));  ?>  
        </header>
        
        <div class="page-body add-body clearfix">
            <fieldset id="artist-board">
                <p><span class="text-danger">*</span> <?php echo __('Please select an artist and ablum before add your lyric.');?><br/></p>
                <div id="artist-section" class="form-group">
                    <p class="help-block"></p>
                    <p><?php echo __('Artist');?><span class="artist-name-ajax"></span></p>
                    <div class="artist-section-content">
                    <?php echo $this->Form->input('artist_name', array('type'=>'select', 'label'=>false, 'options'=>$artists,'empty' => ' ','class'=>'form-control','id'=>'artist-name'));?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id="album-section" class="form-group">
                    <p><?php echo __('Album');?></p>
                    <p class="help-block"></p>
                    <div class="album-section-content">
                    <?php echo $this->Form->input('album_name', array('type'=>'select','label'=>false, 'options'=>false, 'empty' => ' ','class'=>'form-control','id'=>'album-name'));?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-12">
                    <hr/>
                    <span class="pull-right" onclick="setDetails()"><button  class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-ok"> </i> <?php echo __('Select');?></button></span>
                </div>
                <div class="clearfix"></div>
            </fieldset>
            <fieldset id="lyric-board">
                <?php echo $this->Form->create('Lyric'); ?>
                <input id="hidden-artist-name" type="hidden" name="artist_name">
                <input id="hidden-album-title" type="hidden" name="album_title">
                <input id="hidden-artist-unique" type="hidden" name="artist_unique">
                <input id="hidden-album-unique" type="hidden" name="album_unique">
                <div class="form-group">
                    <p class="help-block"><?php echo __(' Title');?></p>
                    <?php echo $this->Form->input('title',array('label'=>false,'class'=>'form-control'));?>                            
                </div>

                <div class="form-group">
                    <p class="help-block"><?php echo __(' Writer');?></p>
                    <?php echo $this->Form->input('writer',array('label'=>false,'class'=>'form-control'));?>                            
                </div>

                <div class="form-group">
                    <p class="help-block"><?php echo __('Composer');?></p>
                    <?php echo $this->Form->input('composer',array('label'=>false,'class'=>'form-control'));?>                            
                </div>
                <div class="form-group">
                    <p class="help-block"><?php echo __(' # (Track-Number)');?></p>
                    <?php echo $this->Form->input('echelon',array('min' => 1,'max' => 35,'label'=>false,'class'=>'form-control'));?>                            
                </div>

                <div class="form-group">
                    <p class="help-block"><?php echo __(' Text');?></p>
                    <?php echo $this->Form->input('text',array('label'=>false,'class'=>'form-control'));?>                            
                </div>

                <div class="form-group">
                    <p class="help-block">
                        <?php echo __(' Source');?><br/>
                        <?php echo __('The source of this is from : %s','');?>
                    </p>
                    <?php echo $this->Form->input('source',array('label'=>false,'class'=>'form-control'));?>                            
                </div>
                <div class="form-group">
                    <?php
                        $requestSubmit=array(
                            'class'=>'btn btn-md btn-primary',
                            'escape' => FALSE,
                            'type' => 'submit',);
                        echo $this->Form->button(' <i class="glyphicon glyphicon-ok"></i>  '.__('Save'), $requestSubmit);
                    ?>        
                </div>
                <?php echo $this->Form->end(); ?>
            </fieldset>
        </div>
    </section>
</main>