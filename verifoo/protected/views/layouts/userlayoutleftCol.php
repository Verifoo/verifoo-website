<div id="leftCol">
		<?php 
		if(isset($model->id)):
					$picture = User::model()->findByPk($model->id);
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
			if(isset(Yii::app()->user->id))
				{
					
					$this->widget('bootstrap.widgets.TbModal', array(
				    'id' => 'sendmessage-form',
				    'header' => 'Send a message',
				    'content' => $this->renderPartial('//layouts/_sendmessage',array('picture'=>$picture,'subject'=>'js:$("#subject").val()','body'=>'js:$("#body").val()'), true),
				    'footer' => array(
				        TbHtml::button('Send Now', array('onclick' => '$("#messageLayoutmodal-form").submit();','data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
				        TbHtml::button('Close', array('data-dismiss' => 'modal')),
				     ),
				 	)); 
				}		
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
			else:
				$f=Friend::model()->find(array('select'=>'confirm,inviteby,friend_id','condition'=>'(user_id=:uID && friend_id=:fID) ||(user_id=:fID && friend_id=:uID)','params'=>array(':uID'=>Yii::app()->user->id,':fID'=>$model->id)));
				if(count($f)>0){
					if($f->confirm==0){
						if($f->inviteby==Yii::app()->user->id)
							echo '<a href="#" class=" btn btn-primary thPic" >Friend request sent</a>';
						else
							echo '<a href="#" class=" btn btn-primary thPic" id="uaddfriend'.$model->id.'" addfriend-id="'.$f->inviteby.'">Confirm friend request</a>';
					}else //if($f->confirm==1)
						echo '<a href="#" class=" btn btn-primary thPic">Your friend</a>';
				}else{
					echo '<a href="#" class=" btn btn-primary thPic" id="uaddfriend'.$model->id.'" addfriend-id="'.$model->id.'">Add friend</a>';
				}	
				
			endif;
		?>
			
				
				
		</div>
		<div class="verticalMenu">
			<ul>
			<?php if(isset(Yii::app()->user->id)):
					if(Yii::app()->user->id!=$model->id):
				?>
				<li><a href="#" class="" id="ufollow<?php if(isset(Yii::app()->user->id)){ echo $model->id;}?>" user-id="<?php echo $model->id;?>"  >Follow </a></li>
				<li><a href="#" data-toggle = 'modal' data-target ='#sendmessage-form' id="usend<?php echo $model->id;?>" user-id="<?php echo $model->id;?>" send-id="<?php //echo $following;?>" >Send message</a></li>
				
			<?php
					else:
							if($model->superuser==1):?>
								<li><a href="<?php echo Yii::app()->createUrl('business/admin');?>" class="" >Businesses</a></li>
								<li><a href="<?php echo Yii::app()->createUrl('user/admin');?>" class="" >Members</a></li>
					  <?php else:
									$b=Business::model()->count('user_id=:uID',array(':uID'=>$model->id));
									 if($b>0):
								?>
								<li><a href="<?php echo Yii::app()->createUrl('profile/business');?>" class="" >Your Businesses</a></li>
							<?php  endif;
							endif;
					endif;
				else:
			?>
				<li><a href="<?php echo Yii::app()->createUrl('user/login');?>" class="" >Follow</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('user/login');?>" class="" >Send message</a></li>			
				<li><a href="<?php echo Yii::app()->createUrl('user/login');?>" class="" >Add friend</a></li>
			
			<?php endif;?>
				
				<li><a href="<?php echo Yii::app()->createUrl('profile/photos');?>" class="" >Photos</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('profile/reviews');?>" class="">
					<?php 
								$n=Review::model()->count('reviewer_id=:uID',array(':uID'=>$model->id));
								echo $n
					?> Reviews</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('profile/favoriteslist');?>" class="" >Favorite list</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('profile/friends',array('id'=>$model->id));?>" class="" >
						<?php 
								$n=Friend::model()->count('user_id=:uID && confirm=1',array(':uID'=>$model->id));
								echo $n
						?> Friends</a></li>
			</ul>
			
		</div>
<script type="text/javascript">
	$(document).ready(function()
		{
			jQuery(function($) {
				jQuery('body').on('click','#uaddfriend<?php echo $model->id;?>',function(){
					 var addfriend_id = $(this).attr("addfriend-id");
					 addFriend(addfriend_id);
				});
			});
		});
	

function addFriend(addfriend_id){
   	var siteDomain = document.domain;
    var siteUrl = 'http://'+siteDomain;
    var urllink = siteUrl+'/profile/addfriend'; 
    var params = "friend_id="+addfriend_id;
   $.ajax({
            	type: "GET",
                url: urllink,
                async: true,
                timeout: 50000,
                data: params,
                success: function(server_response) {	
				var obj = jQuery.parseJSON(server_response);
					$('#uaddfriend<?php echo $model->id;?>').attr('addfriend-id',obj.id);
					$('#uaddfriend<?php echo $model->id;?>').text(obj.status);			
            	}
            });
   
   return false;
}
</script>		
		
		
		<?php 
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