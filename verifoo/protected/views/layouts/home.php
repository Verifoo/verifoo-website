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
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/search.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="home">
<div id="header">
	<div id="headerInner">
		<a href="<?php echo Yii::app()->createUrl('user/login');?>"><div id="signin">Sign in</div></a>
	</div>
</div><!-- header -->
<div class="containerHome" id="pageHome">


	<?php echo $content; ?>

	<div class="clear"></div>

	

</div><!-- page -->
<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Verifoo.com | All Rights Reserved.
</div><!-- footer -->
</body>

</html>
