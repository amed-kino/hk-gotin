<?php echo $this->Form->create('Find', 
        array('url' => array_merge(array('controller' => 'find','action' => 'index'),
                        $this->params['pass']
                    ),
                'class'=> 'navbar-form navbar-right form-inline',
                'role' => 'search'));
?>
    <div class="input-group search-form clearfix">
        <?php echo $this->Form->input('key',array('label' =>false,'div' =>false,'class'=>'search-query form-control','id' =>'search_lg','autocomplete'=>'off','placeholder' => __('Search'),'value' => $this->params['key']));?>

        <div class="input-group-btn">
        <button class="search-query btn">
            <span class="glyphicon glyphicon-search"></span>
        </button>
        </div>
    </div>
<?php echo $this->Form->end();?>