<?php 
 $this->layout='//layouts/main';
?>
<div class="sBDisplay">
		<h2><?php echo UserModule::t("Keyword search: ").$keyword; ?></h2>
		<div class="form">
			<?php echo CHtml::beginForm($this->createUrl('search/index'),'GET',array()); ?> 
				<?php echo TbHtml::textField('searchname', $keyword,array('id'=>'idSearch','append' => TbHtml::submitButton('Search', array('color' => TbHtml::BUTTON_COLOR_PRIMARY,)) , 'span' => 13,'placeholder' => 'Enter business to search...')); ?>
			<?php echo CHtml::endForm(); ?>
		</div>

		<?php
			if($recommend!='')
				echo '<h3>'.$recommend.'.</h3>';
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$b_list,
					'itemView'=>'_businessRender',
					'id'=>'searchlist',
					'enablePagination'=>true,
					'viewData' => array('searchwords'=>$keyword),
					'summaryText'=>'',
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.sblist', 
					        'listViewId'=>'searchlist', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>10, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
		?>
		
</div>