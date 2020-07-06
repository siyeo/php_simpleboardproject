<?php

	$connect = mysqli_connect("localhost:3306", "yeong", "1234", "post") or die ("connect fail");

	//등록이 완료되면 보여줄 페이지
	$URL = './board_list.php';                   //return URL

	$id = $_GET['idx'];

	if(isset($id)){

		//게시글 쿼리문
		$sqlLine = "update board set open=0 where idx = '".$id."'";

		//쿼리문 db로 날리기
		$result = $connect->query($sqlLine);	
		
		if($result){
?>
			<script>
				alert("<?php echo "글이 삭제되었습니다."?>");
			    location.replace("<?php echo $URL?>");
			</script> 

<?php
		}
	}
?>