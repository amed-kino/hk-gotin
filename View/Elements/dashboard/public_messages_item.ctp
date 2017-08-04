<?php 
$marks = $this->HK->marks($Message['marks']);


$destination = isset($marks['destination'])?$marks['destination']:'';
if ($Message['user_1'] == 0 || $User1['name']==null){
    $name = isset($marks['name'])?$marks['name']:'';
    $email = isset($marks['email'])?$marks['email']:'';;
    $username = 'Nenas'.' ( '.$name.' | '.$email .' ) ';
}else{
    $username = $this->Html->link($User1['name'],array('controller' => 'users','action' => 'profile', $User1['unique']));
}
if ($Message['seen']=='yes'){
    $status = '';
}else{
    $status = '('.__('new').')';
}
?>
<div class="public-message-item clearfix">
                   
    <div class="entry col-xs-12">
        <div class="username"><i class="glyphicon glyphicon-user small"></i> <?php echo $username;?> <?php echo $status;?></div>
        <div class="time"><i class="glyphicon glyphicon-time small"></i> <?php echo $this->Time->timeAgoInWords($Message['created']);?></div>
    </div>

    <div class="message clearfix col-xs-12">
        <i class="glyphicon glyphicon-envelope"></i> <?php echo $Message['message'];?>
    </div> 
    <div class="destination col-xs-12">
        <?php echo $destination;?>
        <span class="pull-right"># <?php echo $Message['id'];?></span>
    </div> 
</div>