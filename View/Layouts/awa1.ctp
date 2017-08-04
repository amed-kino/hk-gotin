<?php die('NotReady here now. Sorry.');?><!DOCTYPE html>
<html lang="ku">
<head>
<?php echo $this->Html->charset();?>
<?php echo $this->fetch('meta'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo $this->Html->meta('icon','wene/favicon.png'); ?>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/theme.css">
<?php echo $this->Html->css('hk.css'); ?><?php echo $this->Html->css('marginal-contact.css'); ?><?php echo $this->fetch('css'); ?>

<title><?php if (isset($title)){echo $title;}else{echo 'HK';}?></title>
</head>
<body><?php echo $this->element('contact_us');?>
<div id="page">
<?php echo $this->element('header');?>
<div id="content" class="site-content container">
    <section id="primary" class="content-area col-lg-9 col-md-8  col-sm-12 col-xs-12">
        <?php echo $this->fetch('content'); ?>
    </section>
    <div id="secondary" class="col-lg-3 col-md-4  col-sm-12 col-xs-12" role="complementary">
        <?php echo $this->element('sidebar'); ?>
    </div>
</div>
<?php echo $this->element('footer');?>
</div>  
<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js"></script>
<?php echo $this->Html->script('hk'); ?>
<?php echo $this->Html->script('marginal-contact'); ?>
<?php echo $this->fetch('script');?>
<?php echo $this->Session->flash('flash',array('element'=>"flash"));?> 
<?php if($this->Session->check('Auth.User')):?>

<?php endif;?>
</body>
</html> 