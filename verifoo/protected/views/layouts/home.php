<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<?php if(Yii::app()->user->isGuest):?>
<body class="home">
<div id="header">
		<a href="<?php echo Yii::app()->createUrl('user/login');?>"><div id="signin">Sign in</div></a>
</div><!-- header -->
<div class="containerHome" id="pageHome">

	

	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	

</div><!-- page -->
<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Verifoo.com | All Rights Reserved.
</div><!-- footer -->
</body>
<?php else:?>
<body>
<div id="header">
	<div id="logo">
		<img src="<?php echo Yii::app()->getBaseUrl(true).'/images/logo.256.gif' ?>"/>
		<?php //echo CHtml::encode(Yii::app()->name); ?>
	</div>
</div>
<div id="topOfHeader">
		<div class="topHeaderWrapper"><span>Questions? Give us a call (123) 456-78</span>
			
				<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('../')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					
					array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Create Business', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login "), 'visible'=>Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout ").'('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
				)); ?>
			
		</div>
</div>
<div class="container" id="page">
	
	
	<div id="leftCol">
		<?php if(!Yii::app()->user->isGuest):?>
		<div class="verticalMenu">
				<h4>Users & Groups</h4>
				<?php $this->widget('zii.widgets.CMenu', array(
			    'items'=>array(
					array('label'=>'Home', 'url'=>array('../')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					
					array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Create Business', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login "), 'visible'=>Yii::app()->user->isGuest),
					array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout ").'('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
					),
			)); ?>
		</div>
		<?php endif;?>
	</div>
	<div id="rightCol">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	
	<?php echo $content; ?>
	
	</div>
	<div class="clear"></div>

</div><!-- page -->
<div id="footer2">
		Copyright &copy; <?php echo date('Y'); ?> Verifoo.com | All Rights Reserved.
</div><!-- footer -->
</body>


<?php endif;?>
</html>
