<div id="file-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="file-edit-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-file-edit">
        <?php echo $this->Form->create('FileEditor');?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div class="modal-title" id="myModalLabel">
              <i class="glyphicon glyphicon-hk-player"></i> 
                  <?php echo __('Manipulate the song');?>
          </div>
        </div>
        <div class="file-editor-board">
            <div class="modal-body">
                
                
                
                
                <div class="panel-loader">
                      
                          <div class="waiting col-lg-11 clearfix">
                              <?php echo __('Please wait...');?>
                          </div>
                          <div class="error col-lg-11 clearfix">
                              <i class="glyphicon glyphicon-exclamation-sign"></i>
                              <?php echo __('Cannot Load');?>
                          </div>
                          <div class="clearfix"></div>
                </div>  
                
                <div class="panel-editer">
                    <div class="info">
                        <p>
                            <span class="artist-name">artistName</span> - <span class="lyric-title">title</span><br/>
                            <span class="album-title">albumTitle</span> (<span class="album-year">----</span>)
                        </p>
                    </div>
                    <div class="col-lg-12 clearfix">
                        <div class="form-group input text required">
                          <?php echo $this->Form->input('url',array('type'=>'textarea','label'=>false,'maxlength' => 2048,'class'=>'form-control','placeholder'=>__('File url'),'rows'=>'4'));?>
                      </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="error-board pull-left error">
                            <i class="glyphicon glyphicon-remove"></i> <span class="error-text"></span>
                        </div>
                        <div class="pull-right ajax-spinner-container">
                          <div class="ajax-spinner"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">   
                        <input id="file-unique" type="hidden" name="fileUnique" />
                      <button type="button" id="save-file" class="send-message btn btn-primary"> <?php echo __('Save');?> <i class="glyphicon glyphicon-link"></i> </button>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
                <div class="panel-closer success">
                          <div class="col-lg-11 pull-right clearfix accept">
                              <i class="glyphicon glyphicon-ok"></i> <?php echo __('Your song has been saved successfuly.');?>
                          </div>
                          <div class="clearfix"></div>              
                </div>    
            </div>
        </div>
      </div>
    </div>
  </div>