<?php

	
		require_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../wp-config.php');
		
		global $wpdb;
		$GLOBALS['wpdb'] = $wpdb;
		ob_start();
		
		
		
		$table_name = $wpdb->prefix."like_widget";	
		$secondTableName = $wpdb->prefix."posts";
		
		extract($_POST);//$data	
		extract($data);//$user_id,$post_id,$likeStatus
	
		
		if($_POST){
			
		
   			$date =  new DateTime();
          
			if($likeStatus=="unknown"){

		
				$sql  = "select * from ". $table_name. " where user_id ='".$user_id."'AND post_id =' ". $post_id. "'";
				$wpdb->query($sql);
				$results  = $wpdb->get_results( $sql );

				$rowCount = $wpdb->num_rows;
				
				ob_end_clean();
				
				echo $rowCount;
				
			}
			else if($likeStatus =="GET_LIKES_TEN"){
				echo $user_id;
				$secondTableName = $wpdb->prefix."posts";

//				$sql = "select ".$table_name.".post_id,".$secondTableName .".post_title ,".$table_name.".date_liked from ".$table_name." f,".$secondTableName ." s where f.user_id='".$user_id."' and ". $table_name.".post_id = ".$secondTableName.".ID  order by 'date_liked' LIMIT 10 " ;

				$sql = "SELECT s.post_title,f.date_liked
						FROM ".$table_name." f,". $secondTableName." s 
						WHERE user_id = '".$user_id."'
						AND f.post_id = s.ID
						ORDER BY  'date_liked'
						LIMIT 10";
						
				$wpdb->query($sql);
				$results  = $wpdb->get_results( $sql );
				$rowCount = $wpdb->num_rows;
				ob_end_clean();
				echo json_encode($results);
				
				$wpdb->print_error();
				
				
			}
			else if($likeStatus == "GET_ALL_LIKES"){
				
					$secondTableName = $wpdb->prefix."posts";

				$sql = "select * from ".$table_name. " where user_id= '".$user_id."' order by date_liked ";
				
				$wpdb->query($sql);
				$results  = $wpdb->get_results( $sql );
			//	ob_end_clean();
				echo json_encode($results);
					
			}
			else if($likeStatus == "liked"){
				
				$wpdb->insert( $table_name, array( 'user_id' => $user_id, 'post_id' => $post_id,'date_liked' => $date->getTimestamp() ) );
			}
			else if($likeStatus == "disliked"){
				$wpdb->query(
              'delete from '. $table_name .' where user_id = "'. $user_id.'"AND post_id="'.$post_id.'"');
              $wpdb->print_error();
			}
		}

?>