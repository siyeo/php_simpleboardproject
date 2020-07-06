<!DOCTYPE html>
 
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<style>
			
			.text{
					text-align:center;
					padding-top:20px;
					color:#000000
					float: right;
			}
			.text:hover{
					text-decoration: underline;
			}
		   

			a:hover { text-decoration : underline;}

			.board{
					margin : 20px;
					overflow:hidden;
					width:200px;
					height:250px;
					float:left;
			}
			.image{
					/* display: inline-block; */
					 float: left; 
					width: 200px;
					height: 200px;
					border: 1px solid blue;
					text-align:center;
					box-sizing:border-box;
						}
			.title{
					width: 200px;
					height: 50px;
					float:bottom;
					text-align:center;
			}
			.author{
					width: 200px;
					height: 50px;
					float:bottom;
			}
			.image_size{
					width:200px;
					height:200px;
			}
			
					
	</style>
	<body>

		<h2 align=center>게시판</h2>

			<div class = "text">
			<font style="cursor: hand"onClick="location.href='./write_board.php'">글쓰기</font>
			</div>
		 <?php

				$db  = "mysql:host=localhost; port=3306;dbname=post;charset=utf8";

				try{
						$connect = new PDO($db,"yeong", "1234");

						$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
						$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


						$query ="select idx,title from board where open = 1";


						if ($stmt = $connect->prepare($query)){

						
							/* execute statement */

							$stmt->execute();
							

							/* bind result variables */
						//	 $stmt->bind_result($title);

							$result = $stmt->fetchAll();

								

						/* fetch values */
						foreach($result as $a) {
							
							$image_query = "select * from images where idx = :idx and thumbnail = 1";

							$image_stmt = $connect->prepare($image_query);

							$image_stmt->bindParam(':idx', $a["idx"], PDO::PARAM_INT);

							$image_stmt->execute();

							$image_result = $image_stmt ->fetch();

							
		?>
								
				<div class = "board"> 
					<a href="./update_board.php?idx=<?=$a["idx"];?>">
						<div class = "image" >
							<div><img src="
									<?php 
										if($image_result && ($image_result["idx"] == $a["idx"])){
											
											echo $image_result["image_url"];

										}else {
											echo "./data/duck.png";
										}
									?>" class = "image_size">
									</img>
							</div>
						</div>
						<div class ="title" style="display: inline-block">
							<div><?php echo $a["title"] ?></div>
						</div>
					</a>
				</div>

					 

		<?php
						}
					}
				}catch(PDOException $e){
					echo $e ->getMessage();
				}
		?>    
			
	</body>
</html>
 
