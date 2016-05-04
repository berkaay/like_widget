<?php
/*
/*
Plugin Name: Like Widget
Plugin URI: http://berkaio.xyz
Description: Adds like functionality to wordpress posts
Version: 1.0
Author: Haydar
Authot URI: berkaio.xyz
License: none
*/

require_once( dirname(__FILE__).'/../../../wp-load.php' );
require_once( ABSPATH.'wp-admin/includes/file.php' );
global $wpdb;
//echo get_post_type();
function get_the_post_ID() {
    $post = get_post();
    return ! empty( $post ) ? $post->ID : false;
	}
extract($_POST);
 //create table to use when the plugin is activated
 register_activation_hook( __FILE__, 'like_widget_create_table' );
//drop the table used when the plugin is deactivated
 register_deactivation_hook( __FILE__, 'like_widget_drop_table' );
  	
        function like_widget_create_table() {
		global $wpdb;
		$dbName = DB_NAME;
		$tableName = $wpdb->base_prefix."like_widget";
  
		$create_sql =" CREATE TABLE ".$tableName."(
					`user_id` INT NOT NULL,
				  `post_id` INT NOT NULL,
				  `date_liked` INT NOT NULL,
				  PRIMARY KEY (`user_id`, `post_id`))";
		//wordpress wants me to create a query beacause of security issues		
		// $create_sql ="  CREATE TABLE `".$dbName . "`.`".$tableName."` (
		// 		  `user_id` INT NOT NULL,
		// 		  `post_id` INT NOT NULL,
		// 		  PRIMARY KEY (`user_id`, `post_id`))";
		if($wpdb->query($create_sql)){
			echo "table created";
		}	
		else
		{
			die ("table failed to create");
			echo $create_sql;
		}
        }	
          function like_widget_drop_table(){
         	global $wpdb;
         	$dbName = DB_NAME;
         	$tableName = $wpdb->base_prefix. "like_widget";
         	$drop_sql = "DROP TABLE `".$dbName."`.`".$tableName."`";
         	$wpdb->query($drop_sql);
          }
class like_widget extends WP_Widget {
 
	function __construct() {
		parent :: __construct(false,$name = __('Like Widget'));
	
	}
	function  form($instance) {
	}
	function update($instance, $oldinstance) {
	}
	
	function widget($args,$instance) {
	
		$user_id = get_current_user_id();
		echo "user id = ".$user_id;
		$post_id = get_the_post_ID();
		echo "post id = ".$post_id;
		//print_r(wp_get_sidebars_widgets());
		
		?>
		



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script></script>
					<div class = "widget  like_widget one-third column=">
						

						<button id="like">LIKE</button>
					</div>
					<script>
						$(document).ready(function(){
							var likeObj = {"user_id":"<?php echo $user_id ;?>","post_id":"<?php echo $post_id; ?>"};
							likeObj["likeStatus"]="unknown";
							
							$.ajax({
					 					type : 'POST',
					 					url : '/wp-content/plugins/like_widget/like.php',
					 					data:{data:likeObj},
					 					success:function(data){
					 							
					 						if(data == 0){
					 							$("#like").css("background-color","black");
						 						$("#like").html("LIKE");
					 						}
					 						else if(data == 1){
					 							$("#like").css("background-color","blue");
					 							$("#like").html("LIKED");
					 						}	
					 					} 
					 				});
							
								likeObj['likeStatus']='GET_LIKES_TEN';
								$.ajax({
					 					type : 'POST',
					 					url : '/wp-content/plugins/like_widget/like.php',
					 					data:{data:likeObj},
					 					success:function(data){
					 						//alert(data);
					 						var obj = JSON.parse(data);
					 							for(var key in obj){
					 								let post_id = obj[key]['post_id'];
					 								let post_title = obj[key]['post_title'];
					 								let date_liked = obj[key]['date_liked'];
					 								var date = new Date(date_liked * 1000);
							 					
							 						$("#table").append("<tr><td> "+ post_title + "</td> <td>" 
							 						+ date + "</td><td><a href = '#' class='delete' id =" + post_id + "> delete </a> </td> </tr> ");
					 							}					 						
					 							$("#table").append("<tr><td colspan = '3' ><div id='seeMore' ><a href= '#' id='seeMore' > <p id = 'seeMore' align = 'center'> See More I liked</p> </a></div></td><tr>");
												
												
					 							
					 					}		
					 					 
					 				});
							
					 		$("#like").click(function(){
					 		if(likeObj['user_id']!=0){	
					 			if($("#like").html()=="LIKE"){	
					 				likeObj["likeStatus"]="liked";	 				
						 			$.ajax({
										
						 			 type : 'POST',
					 					url : '/wp-content/plugins/like_widget/like.php',
					 					data:{data:likeObj},
					 					success:function(data){
					 											 					
					 					 $("#like").css("background-color","blue");
						 				 $("#like").html("LIKED");

					 					} 
					 	     			});
					 			}
						 		else{
						 			likeObj["likeStatus"]="disliked";
							 			$.ajax({
							 			type : 'POST',
					 					url : '/wp-content/plugins/like_widget/like.php',
					 					data:{data:likeObj},
					 					success:function(data){
					 						$("#like").css("background-color","black");
							 			 	$("#like").html("LIKE");
					 						}	
					 					});
						 		}
						}
						else{
	    					  window.location= "<?php ABSPATH; ?>wp-login.php";
	 
						}
					 	});
					 	
					 	$(document).on('click', '.delete', function() {
					 		 	likeObj['likeStatus']="disliked";
					 		 	likeObj['post_id'] = $(this).attr('id');
					 		 	$.ajax({			
					 				type : 'POST',
					 				url : '/wp-content/plugins/like_widget/like.php',
					 				data:{data:likeObj},
				 			success:function(data){
				 					location.reload();
	 				
	 					}					 						
		 		
		 		});
		 		 	
		 		 	
		 		 });
		 		
					
					});	
					</script>
					<table id = "table">

						<th colspan=3 style="text-align:center">Posts Liked </th>
							<form style="display: none" action="wp-content/plugins/like_widget/pageLikes.php" method="post" id="form">
								 <input type="hidden" name="user_id"/> 
								 <input type="hidden" name="post_id"/>
							</form>
							<form style="display: none" action="wp-content/plugins/like_widget/like.php" method="post" id="form-delete">
								 <input type="hidden" name="user_id"/> 
								 <input type="hidden" name="post_id"/>
								 <input type="hidden" name="likeStatus"/>
							</form>
							
								<script>
								$(document).ready(function(){
									$(document).on('click', '#seeMore', function() {
				 					  $("input[name=user_id]").val('<?php echo $user_id ?>');
				 					  $("input[name=post_id]").val('<?php echo $post_id ?>');
				 					  $("#form").submit(); });
									
									
									$(document).on('click','.delete', function() {
				 					  $("input[name=user_id]").val('<?php echo $user_id ?>');
				 					  $("input[name=likeStatus]").val('disliked');
									 $("input[name=post_id]").val($(this).data('post_id'));
				 					  $("#form-delete").submit(); });

									});
								
								</script>		

					</table>	
				
		
		<?php
					}
		}
add_action( 'widgets_init', function(){
	register_widget( 'like_widget' );
});	
	
//add_action('widgets_init', create_function('', 'return register_widget("like_widget");'));
?>