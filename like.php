<html>
	<head>
		<title>PagesLiked</title>
			
			<style>
				table {
				    border-collapse: collapse;
				    width: 100%;
				}
				
				th, td {
				    text-align: left;
				    padding: 8px;
				}
				
				tr:nth-child(even){background-color: #f2f2f2}
				
				th {
				    background-color: #4CAF50;
				    color: white;
				}
			</style>
		</head>
	<body>

				 <h1>Pages You Have Liked So Far</h1>
				 	<table id = "table">
		
								<th colspan=3 style="text-align:center">Posts Liked </th>
								
		
							</table>
						
					        
				<script type = "text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
				<script type="text/javascript">
					alert("hi");
						$("#table").ready(function(){
											var likeObj = {"user_id":"<?php echo $user_id ;?>","post_id":"<?php echo $post_id; ?>"};
											likeObj['likeStatus']='GET_LIKES_TEN';
											
											$.ajax({
													
								 					type : 'POST',
								 					url : '/wp-content/plugins/like_widget/like.php',
								 					data:{data:likeObj},
								 					success:function(data){
								 						var obj = JSON.parse(data);
								 							for(var key in obj){
								 							
								 								let post_title = obj[key]['post_title'];
								 								let date_liked = obj[key]['date_liked'];
								 								var date = new Date(date_liked * 1000);
										 						$("#table").append("<tr><td> "+ post_title + "</td> <td>" 
										 						+ date + "</td><td><a id='delete'> delete </a> </td> </tr> ");
								 							}					 						
								 						
								 						
								 					}	
								 					 
								 				});
										});
					</script>
			
			
		
	</body>	
</html>
