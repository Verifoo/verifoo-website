<div class="businesslist">
		<h2><?php echo UserModule::t("Keyword search:"); ?></h2>
		<?php 
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$b_list,
				'itemView'=>'_businessRender',
				'enablePagination'=>true,
				'summaryText'=>'',
				'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5),
			)); 
		?>
		
</div>