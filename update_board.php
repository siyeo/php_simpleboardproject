<!DOCTYPE>
 
<html>
<head>
	<meta charset = 'utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
	table.table2{
			border-collapse: separate;
			border-spacing: 1px;
			text-align: left;
			line-height: 1.5;
			border-top: 1px solid #ccc;
			margin : 20px 10px;
	}
	table.table2 tr {
			 width: 50px;
			 padding: 10px;
			font-weight: bold;
			vertical-align: center;
			border-bottom: 1px solid #ccc;
	}
	table.table2 td {
			 width: 100px;
			 padding: 10px;
			 vertical-align: center;
			 border-bottom: 1px solid #ccc;
	}

	table.imagetable td {
			 
			 vertical-align: center;
			 border-bottom: none;
			 font-size: small;
	}

	.delete{
			text-align:center;
			padding-top:20px;
			color:#ff0000;
		
	}
	.delete:hover{
			text-decoration: underline;
	}
 
</style>
<body>

	<?php
		$db  = "mysql:host=localhost; port=3306;dbname=post;charset=utf8";

		$id = $_GET['idx'];

		if(isset($id)){

			try{
				$connect = new PDO($db,"yeong", "1234");
				$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
				$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$query ="select * from board where idx = '".$id."'";

				if ($stmt = $connect->prepare($query)){

					/* execute statement */

					$stmt->execute();
					$result = $stmt->fetch();
	?>

	<form name = "check" method = "post" action = "update_action.php" enctype='multipart/form-data'>
		<input type="hidden" name='idx' value="<?php echo $result['idx'];?>">
		<table  style="padding-top:50px" align = center width=700 border=0 cellpadding=2 >
			<tr>
				<td height=20 align= center bgcolor=#ccc><font color=white> 글쓰기 </font></td>
			</tr>
			<tr>
				<td bgcolor=white>
				<table class = "table2">
					<tr>
						<td >작성자</td>
						<td><input type = "text" name = 'author' size=20 value="<?php echo $result['author']; ?>"> </td>
					</tr>

					<tr>
						<td >제목</td>
						<td><input type = "text" name = 'title' size=60 value="<?php echo $result['title']; ?>"></td>
					</tr>

					<tr>
						<td >내용</td>
						<td><textarea name = "context" cols=85 rows=15><?php echo $result['context']; ?></textarea></td>
					</tr>
					<tr>
						<td >이미지(썸네일은 하나만 선택 가능)</td>
						<td>
							<table class ="imagetable">

								<?php 
							
								/* fetch values */
								
								$image_query = "select * from images where idx = '".$id."'";

								$image_stmt = $connect->prepare($image_query);
								//$image_stmt->bindParam($id, $a["idx"], PDO::PARAM_INT);
								$image_stmt->execute();
								$image_result = $image_stmt ->fetchAll();
									
								foreach($image_result as $image){

									$image_id = $image['image_id'];

								?>
								<td width = 50><?= $image['image_name'] ?></td>
								<td><input type="checkbox" name="del_image" value="<?= $image_id ?>">삭제</td>
								<td><input type="radio" name="thumbnail" value="<?= $image_id ?>">썸네일</td>
									
								<?php
								}
								?>
								
								<td><input type="file" name="image" id="image" value=""></td>
								<td><input type="radio" name="thumbnail" value="first">썸네일</td>
							</table>
						</td>							
					</tr>
				</table>

			<?php
					}else{
					}
				}catch(PDOException $e){
					echo $e ->getMessage();
				}
			}
			?>
				<center>
				<input type = "submit" value="작성">
				</center>
				</td>
			</tr>
		</table>
	</form>
					
	<form method = "post" action = "del_board.php?idx=<?php echo $id;?>" enctype='multipart/form-data'>
		<div class = "delete">
		<input type = "submit" value="삭제">
		</div>
	</form>
</body>
</html>
 