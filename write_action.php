<?php
	$connect = mysqli_connect("localhost:3306", "yeong", "1234", "post") or die ("connect fail");


	$author = $_POST['author'];                      //작성자
	$title = $_POST['title'];                  //Title
	$context = $_POST['context'];              //Content
	$date = date('Y-m-d H:i:s');            //Date

	if(isset($_POST['thumbnail'])){
	$thumbnail = $_POST['thumbnail'];     //thumbnail
	}


	//등록이 완료되면 보여줄 페이지
	$URL = './board_list.php';                   //return URL

	//게시글 쿼리문
	$sqlLine = "insert into board ( author ,title, context, time, open) 
			values( '$author','$title', '$context', '$date', 1)";
		   
	//$query = mysqli_query($connect, $sqlLine)or die(mysqli_error($sonnect));


	//쿼리문 db로 날리기
	$result = $connect->query($sqlLine);	



	/* 이미지 저장 */



	//변수가 선언되었는지 확인 하는 함수 ISSET
	if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
	//FILES은 앞에 선언해준 [enctype='multipart/form-data] 로 인한 임의의 변수
	$file = $_FILES['image'];

	$upload_directory = './data/';
	//확장자 범위 선정
	$ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,gif,png,txt,ppt,pptx";
	//위의 확장자를 ,단위로 나눔 explode : 문자열을 나눔
	$allowed_extensions = explode(',', $ext_str);


	//파일 최대 크기 정함
	$max_file_size = 5242880;
	//substr(입력 문자열, 0부터 시작해서 반환할 문자 수 : 문자열의 일부를 반환한다. strrpos(검색할 문자열,기준값,검색 시작할 위치): 문자열에서 마지막으로 나타나는 부분 문자열의 위치를 찾는다.
	//파일 이름에서 확장자 부분을 잘라서 반환
	$ext = substr($file['name'], strrpos($file['name'], '.') + 1);


	// 확장자 체크
	if(!in_array($ext, $allowed_extensions)) {
		echo "업로드할 수 없는 확장자 입니다.";
	}

	// 파일 크기 체크
	if($file['size'] >= $max_file_size) {
		echo "5MB 까지만 업로드 가능합니다.";
	}


	//md5 : 문자열의 md5해시를 계산 microtime : 현재 유닉스 타임스탬프를 마이크로 초로 반환합니다.
	$path = md5(microtime()) . '.' . $ext;
	//move_uploaded_file : 업로드 된 파일을 새로운 위치로 이동
	if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
		//images 쿼리문
		$query = "INSERT INTO images( idx,image_name,image_url,thumbnail) VALUES(?,?,?,?)";
		//위의 board쿼리로 보낸 정보의 idx를 가져옴
		$idx = mysqli_insert_id($connect);

		$image_name = $file['name'];
		$image_path = $upload_directory.$path;

		
		//실행을 위한 sql문 준비
		$stmt = mysqli_prepare($connect, $query);
		//변수를 준비된 명령문에 매개변수로 바인드 : true가 성공
		$bind = mysqli_stmt_bind_param($stmt, "sssi", $idx, $image_name, $image_path,$thumbnail);
		//준비된 퀴리문 실행
		$exec = mysqli_stmt_execute($stmt);

	  

		mysqli_stmt_close($stmt);

		

		echo"<h3>파일 업로드 성공</h3>";


	}

	} else {

		echo "<h3>파일이 업로드 되지 않았습니다.</h3>";
	
	}

	/* 이미지 thumbnail 선택 */

		if(isset($thumbnail_id)){

		if($thumbnail_id != "first"){

		$thumbnail_query = "update images set thumbnail =1 where image_idx = '".$thumbnail_id."'";

		$thumbnail_stmt = $connect->prepare($thumbnail_query);

		//$image_stmt->bindParam($id, $a["idx"], PDO::PARAM_INT);

		$thumbnail_stmt->execute();

		$thumbnail_result = $thumbnail_stmt ->fetch();

			}
		}


	if($result && !empty($title)){

	?>  
		<script>
			alert("<?= '글이 등록되었습니다.'?>");
			location.replace("<?php echo $URL?>");
		</script> 
		
	<?php
	}
	else{
		?>
			
		<script>
			alert("<?='제목을 입력하세요'?>");
			echo "<a href="javascript:history.go(-1);">이전 페이지</a>";  
		</script> 

	<?php
		echo mysqli_error($connect);
	}

	mysqli_close($connect);
?>
 
