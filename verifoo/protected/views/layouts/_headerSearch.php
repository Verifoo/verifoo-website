<div class="headSearch">
	
			<h1 id="lText">Veri<span class="yellow">foo</span></h1>
		
	<div class="form">
		<?php echo CHtml::beginForm($this->createUrl('search/index'),'GET',array()); ?> 
		
			<?php echo CHtml::textField('searchname', '',array('id'=>'searchbar', 'width'=>100, 'maxlength'=>100,'class'=>'indexSearch','placeholder'=>'Enter business to search')); ?>
			
				<?php echo CHtml::submitButton('', array('id'=>'i_search', 'name'=>'bsearch')); ?>
				
		<?php echo CHtml::endForm(); ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function()
		{
			jQuery(function($) {
				jQuery('body').on('click','#i_search',function(){
					 var sval = $('#searchbar').val();
    				if( sval.length < 4){
    					alert('Search word should be greater than 3 characters');
    					return false;
    				}
				});
			});
		});
</script>