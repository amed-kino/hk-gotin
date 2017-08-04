<!DOCTYPE html>
<html lang="ku">
<head>
<?php
$cdn = Configure::read('HK.cdn');
?>
<?php echo $this->Html->charset();?>
<?php echo $this->fetch('meta'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo $this->Html->meta('icon','wene/favicon.png'); ?>

<link rel="stylesheet" href="<?php echo $cdn['bootstrapCss'];?>">
<link rel="stylesheet" href="/css/hk.css">
<?php echo $this->fetch('css'); ?>
<?php echo $this->fetch('scriptHeader');?>

<title><?php echo isset($title)? $title : 'HK' ; ?></title>
</head>
<body>

<header id="site-header">
<?php echo $this->element('header');?>
</header>
<section id="site-body" class="col-lg-12 clearfix">
    <?php echo $this->element('sidebar_dashboard'); ?>
    <section id="primary" class="content-area col-lg-9 col-md-8  col-sm-12 col-xs-12">
        <?php echo $this->fetch('content'); ?>
    </section>
    <section id="secondary" class="col-lg-3 col-md-4  col-sm-12 col-xs-12">
        <?php echo $this->element('sidebar'); ?>
    </section>
</section>
<footer id="site-footer" class="col-lg-12 clearfix">
    <?php echo $this->element('footer');?>
</footer>
  
<script src="<?php echo $cdn['jqueryJs'];?>" type="text/javascript"></script>
<script src="<?php echo $cdn['bootstrapJs'];?>"></script>
<?php echo $this->Html->script('hk-users'); ?>
<?php echo $this->fetch('script');?>
<?php echo $this->fetch('scriptBottom');?>
<?php echo $this->Session->flash('flash',array('element'=>"flash"));?> 
<?php if($this->Session->check('Auth.User')):?>

<?php endif;?>
</body>
</html> 