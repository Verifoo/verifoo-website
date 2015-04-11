<?php $this->pageTitle=Yii::app()->name;?>

<?php if(Yii::app()->user->isGuest):?>


<div id="indexBody">
	<div class="topBody">
		<div class="d_img">
			<img src="<?php echo Yii::app()->getBaseUrl(true).'/images/mascot2.png' ?>"/>
		</div>
		<div class="d_text">
			<h1 id="indexLogoText">Veri<span class="yellow">foo</span></h1>
			<div class="tagline">search &#183; verify  &#183;  validate</div>
		</div>
	</div>
	<div class="bottomBody">
		<div class="form">
			<?php echo CHtml::beginForm($this->createUrl('search/index'),'GET',array()); ?> 
			
				<?php echo CHtml::textField('searchname', '',array('id'=>'idSearch', 'width'=>100, 'maxlength'=>100,'class'=>'indexSearch','placeholder'=>'Enter business to search')); ?>
				<div class="bottom2Body">
					<?php echo CHtml::submitButton('Verifoo Search', array('class'=>'i_sub', 'name'=>'bsearch')); ?>
					<a href="<?php echo Yii::app()->createUrl('site/page', array('view'=>'about'));?>"><div class="i_sub2">About Verifoo</div>
				</div>
			<?php echo CHtml::endForm(); ?>
		</div>
	</div>
</div>	

<?php 
 if(is_array($searchkeywords) && sizeof($searchkeywords)>0):
 ?>
 	
 	<div class="searchedKeywords">
 		<?php foreach($searchkeywords as $keyword):
			  	echo "<a href=".Yii::app()->createUrl('search/index', array('searchname'=>strtolower($keyword)))."><div style='display:inline-block'> ".strtolower($keyword)." </div></a>";
			  endforeach;
		?>
 	</div>	
 <?php
 
 endif;

else:	
		$model = User::model()->findbyPk(Yii::app()->user->id);
		$this->renderPartial('//layouts/userlayoutleftCol', array('model'=>$model)); 
?>
<div id="rightCol">
	<div class="searchMainBox">
		
	</div>
	<?php
	
		$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$b_list,
					'itemView'=>'_mainBusinessRender',
					'id'=>'searchlist',
					'enablePagination'=>true,
					'summaryText'=>'',
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.sblist', 
					        'listViewId'=>'searchlist', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>6, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
	?>
</div>	
<?php endif;?>