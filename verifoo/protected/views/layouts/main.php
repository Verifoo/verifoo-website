<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php Yii::app()->bootstrap->register(); ?>
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/search.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php /*<div id="header">
	<div id="logo">
		<a href="<?php echo Yii::app()->getBaseUrl(true);?>"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/logo.256.gif' ?>"/></a>
		<?php //echo CHtml::encode(Yii::app()->name); ?>
	</div>
</div>*/?>
<div id="topOfHeader">
		<div class="topHeaderWrapper"><span>Questions? Give us a call (123) 456-78</span>
			
				<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('../')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Messages', 'url'=>array('/messages/')),
					
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
		<?php 
		//$xpage = 1;
		
		if(!Yii::app()->user->isGuest):
					$picture = User::model()->findByPk(Yii::app()->user->id);
		if(Yii::app()->controller->id!='business' || Yii::app()->controller->action->id!='view'):
			//$xpage = 0;		
			?>	
		<div class="userprofile">
			<?php //if(sizeof($picture)>0 && $picture->image!=null):?>
					<?php $this->widget('ext.SAImageDisplayer', array(
					    'image' => $picture->image,
					    'size' => 'p190',
					    'group' => 'users',
					    'defaultImage' => 'default.jpg',
					    'title' => 'Profile Image',
					)); ?>
			<?php //endif;
					
			if($picture->id==Yii::app()->user->id):
				 $this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'tbmodal-form1',
				    'header' => 'Profile Picture',
				    'content' => $this->renderPartial('//layouts/_uploadprofile',array('picture'=>$picture,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				        TbHtml::button('Upload Photo', array('onclick' => '$("#mainlayoutmodal-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				 )); 
				
				echo TbHtml::button('Upload Profile Picture', array(
				    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
				    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
				    'data-toggle' => 'modal',
				    'data-target' => '#tbmodal-form1',
				    'id'=>'mainlayoutUploadProfile',
				    'class' =>'btn btn-primary'
				)); 
			
			endif;
			?>
			
				
				
		</div>
		<div class="verticalMenu">
			
			<?php /*if(isset(Yii::app()->user->id)):
			 	//<h4 class="prepend-24">Businesses</h4>
				$this->widget('application.components.BusinessMenu');
				endif;*/
			?>
				<?php $this->widget('zii.widgets.CMenu', array(
			    'items'=>array(
					array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Follow"), 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Send message', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Add friend', 'visible'=>!Yii::app()->user->isGuest),
					array('url'=>array('/business/create'), 'label'=>'Photos', 'visible'=>!Yii::app()->user->isGuest),
					),
			)); ?>
		</div>
		
		
		
		<?php 
		endif;
		endif;
		
		if(Yii::app()->controller->id=='search' || Yii::app()->controller->action->id=='index'):
				$searchkeywords = null;
				$cookieJar = Yii::app()->request->getCookies();
					if(isset($cookieJar['keysearch']->value))
					  $searchkeywords = $cookieJar['keysearch']->value;
				if(isset($searchkeywords) && sizeof($searchkeywords)>0){
					 
					echo '<div class="verticalMenu"><h4 class="prepend-24">Searched Words</h4>
						    <div>';
								foreach($searchkeywords as $keyword):
								  	echo "<a href=".Yii::app()->createUrl('search/index', array('searchname'=>strtolower($keyword)))."><div class='prepend-25 block'> ".strtolower($keyword)." </div></a>";
								endforeach;
					echo'   </div>
						 </div>';
				} 
		endif;
	?>
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
</html>
