<div id="leftCol">
<?php 
	if(!Yii::app()->user->isGuest):
		if($this->id=='photos' || $this->action->id=='view'){
				$picture = User::model()->findByPk($_GET['id']);
		}else{
				$picture = User::model()->findByPk(Yii::app()->user->id);
		}
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
		<h4 class="prepend-24">Businesses</h4>
		<?php if(isset(Yii::app()->user->id)):
			
			$this->widget('application.components.BusinessMenu');
			endif;
		?>
		<h4 class="prepend-24">Menu</h4>
			<?php $this->widget('zii.widgets.CMenu', array(
		    'items'=>array(
				array('url'=>Yii::app()->getModule('user')->profileUrl, 'label'=>Yii::app()->getModule('user')->t("Favorites"), 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>array('/business/create'), 'label'=>'Create Business', 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>array('/business/create'), 'label'=>'Messages', 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>array('/reviews/'), 'label'=>'Reviews', 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login "), 'visible'=>Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout ").'('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
				),
		)); ?>
		
	</div>
	
	
	
<?php 
	endif;	
?>
</div>