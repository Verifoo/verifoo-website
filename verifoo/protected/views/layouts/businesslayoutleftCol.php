<?php
	$votes = Yii::app()->db->createCommand()
		    ->select('r.rate')
		    ->from('review r')
			->where('business_id='.$model->id)
			->queryAll();	
	if(sizeof($votes)>0){
		$displayedReports = array(1=>0,2=>0,3=>0,4=>0,5=>0);
		foreach($votes as $key =>$ratevalue)
		{
			$key = $ratevalue['rate'];
			$displayedReports[$key] = $displayedReports[$key] + 1;
		}
	}
?>
<div id="businessLCol">
	<div class="userprofile">
				<?php $this->widget('ext.SAImageDisplayer', array(
				    'image' => $model->logo,
				    'size' => 'p240',
				    'group' => 'business',
				    'defaultImage' => 'default.jpg',
				)); ?>
		
		<?php 
			

			if($model->user_id==Yii::app()->user->id):
				$this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'tbmodal-form1',
				    'header' => 'Business Logo',
				    'content' => $this->renderPartial('_uploadLogo',array('picture'=>$model,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				        TbHtml::button('Upload Image', array('onclick' => '$("#mainlayoutmodal-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				));
			 
				echo TbHtml::button('Upload Business Logo', array(
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
		<ul>
			<?php if(isset(Yii::app()->user->id)):
				$following=Businessfollow::model()->find(array(
				    'select'=>'id',
				    'condition'=>'user_id=:userID && business_id=:bID',
				    'params'=>array(':userID'=>Yii::app()->user->id,':bID'=>$model->id),
				));
					if(count($following)>0)
						$following = $following->id;
		
					$this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'sendmessage-form',
				    'header' => 'Send a message',
				    'content' => $this->renderPartial('//layouts/_sendmessagebusiness',array('picture'=>$model,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				        TbHtml::button('Send Now', array('onclick' => '$("#messageLayoutmodal-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				 	)); 	
			
			
			
				if(Yii::app()->user->id!=$model->user_id):
			?>
					<li><a href="#" data-toggle = 'modal' data-target ='#sendmessage-form' id="bsend<?php echo $model->id;?>" business-id="<?php echo $model->id;?>" business-id="<?php //echo $following;?>" >Send message</a></li>
					<li><a href="#" class="" id="bfollow<?php echo $model->id;?>" business-id="<?php echo $model->id;?>" follow-id="<?php echo $following;?>" ><?php if($following==0){echo ' Follow ';}else{echo ' Stop Following';}?></a></li>
		<?php
				else:
						$nf=Businessfollow::model()->count('business_id=:bID',array(':bID'=>$model->id));
					    $np=Businessphoto::model()->count('business_id=:bID && status=0',array(':bID'=>$model->id));
				?>
					<li><a href="<?php echo Yii::app()->createUrl('business/messages');?>" class="" >View Messages</a></li>	
					<li><a href="<?php echo Yii::app()->createUrl('business/followers');?>" class="" ><span class="number"> <?php if($nf>0){echo '('.$nf.')';}?></span> Followers <?php if($nf>0){echo '('.$nf.')';}?></a></li>
					<?php if($np>0){?><li><a href="<?php echo Yii::app()->createUrl('business/photos',array("id"=>$model->id,'#'=>'ap'));?>" class="" ><span class="number"><?php echo $np;?> </span> Photos Need Approval </a></li><?php }?>
		<?php
				endif;
			else:
		?>
			<li><a href="<?php echo Yii::app()->createUrl('user/login');?>" class="" >Send message</a></li>			
			<li><a href="<?php echo Yii::app()->createUrl('user/login');?>" class="" >Follow</a></li>
		
		<?php endif;?>
			
		</ul>
	</div>
	
<script type="text/javascript">
$(document).ready(function()
	{
		jQuery(function($) {
			jQuery('body').on('click','#bfollow<?php echo $model->id;?>',function(){
				 var data_id = $(this).attr("business-id");
				 var data_follow = $(this).attr("follow-id");
					 followBusiness(data_id,data_follow);
				});
			});
		});
	

function followBusiness(data_id,data_follow){
   	var siteDomain = document.domain;
    var siteUrl = 'http://'+siteDomain;
var urllink = siteUrl+'/business/follow'; 

var params = "data_id="+data_id+"&follow_id="+data_follow;
   $.ajax({
            	type: "POST",
            url: urllink,
            async: true,
            timeout: 50000,
            data: params,
            success: function(server_response) {	
			var obj = jQuery.parseJSON(server_response);
				$('#bfollow<?php echo $model->id;?>').attr('follow-id',obj.id);
				$('#bfollow<?php echo $model->id;?>').text(obj.status);			
            	}
            });
   
   return false;
}
</script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
	
	<?php 
	if(sizeof($votes)>0):
		if(sizeof($displayedReports)>0)	:
				
	?>
		<div>
			<script type="text/javascript">
			      google.load("visualization", "1", {packages:["corechart"]});
			      google.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable(
						[
					         ['Star', 'Votes', { role: 'style' }],
					         ['1 Star', <?php echo $displayedReports[1];?>, '#3366cc'],            // RGB value
					         ['2 Stars', <?php echo $displayedReports[2];?>, '#dc3912'],            // English color name
					         ['3 Stars', <?php echo $displayedReports[3];?>, '#ff9900'],
					         ['4 Stars', <?php echo $displayedReports[4];?>, '#109618' ], // CSS-style declaration
							 ['5 Stars',<?php echo $displayedReports[5];?>, '#0099c6' ], // CSS-style declaration	
					    ]);
			
			        var options = {
						legend:'none',
			          	title: "<?php echo " Review Standing"?>",
			          	animation:{
					        duration: 1000,
					        easing: 'out',
					      },
			          	hAxis:{viewWindow: {min: 0, max: 5.6}}
			        };
			
			        var chart = new google.visualization.BarChart(document.getElementById('chart_div<?php echo $model->id;?>'));
			        chart.draw(data, options);
			      }
	   	 	</script>
			<div id="chart_div<?php echo $model->id;?>" style="width: 240px; height: 240px;"></div>	
	
		</div>	
	<?php			
		endif;	
	endif;
	?>	
</div>