<?php $this->renderPartial('//layouts/businesslayoutleftCol', array('model'=>$model,'profile'=>$profile)); 

Yii::app()->user->returnUrl = Yii::app()->request->requestUri;
?>

<div id="businessRCol">		
<div class="businesslinks">
	<ul>
		<li class="activepage">
			About
		</li>
		<li class="btn-primary">
			<a href="<?php echo Yii::app()->createUrl('business/photos', array('id' => $model->id));?>">Photos</a>
		</li>
		<li class="btn-primary">
			<a href="<?php echo Yii::app()->createUrl('business/photos', array('id' => $model->id));?>">Activities</a>
		</li>
	</ul>
</div>
<h2><?php echo $model->businessname; 
			echo '<div class="bStars">';
					//for($x=1;$x<=$numstar;$x++)
					 echo '<div class="star" style="width:'.(16*round($model->reviewAve)).'px"></div>';
				
			echo'</div>';
		if(Yii::app()->user->id==$model->user_id){
	  	 echo"<span class='h2span'>
	  	 		<a href='".Yii::app()->createUrl('business/update', array('id' => $model->id))."'>( Edit Business )</a>
	  	 	</span>";
		}
		//echo $model->reviewSum."--".$model->reviewCount.":".round($model->reviewSum/$model->reviewCount);
	?>
	
<div class="socialsites">
	<?php if(isset($profile->facebook_page) && $profile->facebook_page!=''):?>
				<a href="https://www.facebook.com/<?php echo $profile->facebook_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/facebook_icon.png' ?>"></a>
	<?php endif;
	if(isset($profile->twitter_page) && $profile->twitter_page!=''):?>
			<a href="https://twitter.com/<?php echo $profile->twitter_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/twitter_icon.png' ?>"></a>
	<?php endif;
	 if(isset($profile->gplus_page) && $profile->gplus_page!=''):?>
			<a href="https://plus.google.com/<?php echo $profile->gplus_page;?>" target="_blank"><img src="<?php echo Yii::app()->getBaseUrl(true).'/images/google_icon.png' ?>"></a>
	<?php endif;?>		
</div>	
</h2>

<div class="businessInfo">
	<p class="businessfield">Founded: <span class="lightblue"><?php echo date("M d, Y",strtotime($profile->foundeddate));?></span></p>
	<?php if(isset($profile->dti_number) && $profile->dti_number!=''):?>
	<p class="businessfield">DTI No.: <span class="lightblue"><?php echo ucwords($profile->dti_number);?></span></p>
	<?php endif;?>
	<p class="businessfield">Open Schedule: <span class="lightblue"><?php echo ucwords($profile->openschedule);?></span></p>
	<?php if(isset($profile->website) && $profile->website!=''):?>
	<p class="businessfield">Website: <span class="lightblue"><?php echo ucwords($profile->website);?></span></p>
	<?php endif;?>
	<p class="businessfield">Contact #: <span class="lightblue"><?php echo $model->phonenumber;?></span></p>
	
	<p class="businessfield">Views: <span class="lightblue"><?php echo $model->views;?></span></p>
	<p class="businessfieldBlock">Business Type: <span class="lightblue"><?php 
		$category = explode(":",$model->category);
	echo implode(", ",$category);	
	?></span></p>
	<p class="businessfieldBlock">Address: <span class="lightblue"><?php echo ucwords($model->address);?></span></p>
	<div class="businessDescription">
		<?php echo $model->description;?>
	</div>
</div>

<?php
//
// ext is your protected.extensions folder
// gmaps means the subfolder name under your protected.extensions folder
//  
if(is_numeric($profile->latitude) && is_numeric($profile->longitude)):

Yii::import('ext.gmap.*');
 
$gMap = new EGMap();
$gMap->zoom = 16;
$gMap->setCenter($profile->latitude, $profile->longitude);
 
// Create GMapInfoWindows
$info_window_a = new EGMapInfoWindow('<div><strong>'.$model->businessname.'</strong><br></div>');

 
// Create marker
$marker = new EGMapMarker($profile->latitude, $profile->longitude, array('title' => $model->businessname));
$gMap->addMarker($marker);
$gMap->renderMap();
?>
<?php 
else:
	echo "<div> No map created</div><br/>";
endif;

?>
<a name="reviews"></a>
<div class="reviews">
	<h3>Reviews </h3>
	<?php 
	if(isset(Yii::app()->user->id)):
	if(Yii::app()->user->hasFlash('rated')): ?>
	
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('rated'); ?>
		</div>
	<?php else: 
			if(Yii::app()->user->id!= $model->user_id):
				$reviewmodel->reviewer_id = Yii::app()->user->id; 
				$reviewmodel->business_id = $model->id; 
				 $this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'tbmodal-reviewform',
				    'header' => 'Write a Review for '.ucwords($model->businessname),
				    'content' => $this->renderPartial('_reviewform',array('picture'=>$model,'reviewmodel'=>$reviewmodel,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				    	TbHtml::button('Submit Review', array('onclick' => '$("#mainlayoutreview-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				)); 
				 
				if(count($exists)>0){
				 	echo '<a href="'.Yii::app()->createUrl('review/edit',array('id'=>$exists->id)).'" class="btn btn-primary">Update review for '.ucwords($model->businessname).'</a>';
				}else{
					echo TbHtml::button('Write a review for '.ucwords($model->businessname), array(
					    'style' => TbHtml::BUTTON_COLOR_PRIMARY,
					    'size' => TbHtml::BUTTON_SIZE_DEFAULT,
					    'data-toggle' => 'modal',
					    'data-target' => '#tbmodal-reviewform',
					    'id'=>'mainlayoutReviewForm',
					    'class' =>'btn btn-primary'
					));
				}
			endif;
		
	endif;
else:
	echo '<a class="btn btn-primary" href="'.Yii::app()->createUrl('user/login').'">Signup/Login to Write a review</a>';
endif;//end of if user is login
	
				if($model->user_id!=Yii::app()->user->id)
					$emptyText = '<br/>Be the first to write a review for '.ucwords($model->businessname);
				else
					$emptyText = 'You owned '.ucwords($model->businessname).'<br/>No reviews yet';
				
				$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$reviews,
					'itemView'=>'_reviewsRender',
					'id'=>"review_list",
					'enablePagination'=>true,
					'emptyText' => $emptyText,
					//'template'=>"{pager}\n{items}\n{pager}",
					'summaryText'=>'',
					//'pager' => array('class' => 'CLinkPager', 'header' => '','maxButtonCount' => 5), 
					'pager' => array(
		                    'class'=>'ext.infiniteScroll.IasPager', 
					        'rowSelector'=>'.reviewlist', 
					        'listViewId'=>'review_list', 
					        'header'=>'',
					        'loaderText'=>'Loading...',
					        'options'=>array(
						            'history'=>false, 
						            'triggerPageTreshold'=>32, 
						            'trigger'=>'Load more'
					        	),
	                   )
				)); 
			
		?>
</div>
<script type="text/javascript">
$(document).ready(function()
	{
		jQuery(function($) {
			jQuery('body').on('click','.ufollow',function(){
				var jThis = $(this);
				 var reviewer_id = $(this).attr("reviewer-id");
				 var review_id = $(this).attr("id");
					 followUser(this,reviewer_id,review_id);
					 return false;
				});
			jQuery('body').on('click','.afriend',function(){
				var jThis = $(this);
				 var reviewer_id = $(this).attr("reviewer-id");
				 var review_id = $(this).attr("id");
					 addFriend(this,reviewer_id,review_id);
					 return false;
				});	
			});
			
		});
function followUser(jThis,reviewer_id,review_id){
   	var siteDomain = document.domain;
    var siteUrl = 'http://'+siteDomain;
var urllink = siteUrl+'/profile/follow'; 

var params = "reviewer_id="+reviewer_id+"&review_id="+review_id;
   $.ajax({
            	type: "GET",
            url: urllink,
            async: true,
            timeout: 50000,
            data: params,
            success: function(server_response) {	
				var obj = jQuery.parseJSON(server_response);
					$(jThis).text(obj.status);
					return false;
            	}
            });
   
   return false;
}
function addFriend(jThis,reviewer_id,review_id){
   	var siteDomain = document.domain;
    var siteUrl = 'http://'+siteDomain;
    var urllink = siteUrl+'/profile/addfriend'; 
var params = "friend_id="+reviewer_id;
   $.ajax({
            	type: "GET",
            url: urllink,
            async: true,
            timeout: 50000,
            data: params,
            success: function(server_response) {	
				var obj = jQuery.parseJSON(server_response);
					$(jThis).text(obj.status);
					return false;
            	}
            });
   
   return false;
}
</script>
</div>