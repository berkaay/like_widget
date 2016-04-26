<?php
		//require_once( ABSPATH. '/wp-load.php' );
		global $wpdb;
		
		$table_name = $wpdb->prefix . "like_widget";	
		
		extract($_POST);//$data			
		if($_POST){
			extract($_POST['data']);
   			$date =  new DateTime();
           
			if($likeStatus=="unknown"){
				$sql  = "select * from ". $table_name. " where user_id ='".$user_id."'AND post_id =' ". $post_id. "'";
				$wpdb->query($sql);
				$results  = $wpdb->get_results( $sql );

				$rowCount = $wpdb->num_rows;

				echo $rowCount;
			}
			else if($likeStatus =="GET_LIKES_TEN"){
				$secondTableName = $wpdb->prefix."posts";

				$sql = "select post_title , date_liked from ".$table_name.",".$secondTableName ." where user_id='".$user_id."' and ". $table_name.".post_id = ".$secondTableName.".ID  order by 'date_liked' LIMIT 10 " ;
				
				$wpdb->query($sql);
				$results  = $wpdb->get_results( $sql );
				$rowCount = $wpdb->num_rows;

				echo json_encode($results);
			}
			else if($likeStatus == "GET_ALL_LIKES"){
				$sql = "select * from ".$table_name. "where user_id='".$user_id."' order by date_liked";

			}
			else if($likeStatus == "liked"){
				
				$wpdb->insert( $table_name, array( 'user_id' => $user_id, 'post_id' => $post_id,'date_liked' => $date->getTimestamp() ) );
			}
			else if($likeStatus == "disliked"){
				$wpdb->query(
              'delete from '. $table_name .' where user_id = "'. $user_id.'"AND post_id="'.$post_id.'"');
			}
		}
?>