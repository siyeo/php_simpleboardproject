<!DOCTYPE>
 
<html>
<head>
	<meta charset = 'utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="http://code.jquery.com/jquery-latest.js"></script>

	<script>
		$(function check(){
			$("input[type=submit]").click(function(){
				var result = $("input[type=text]").val();
				if(!result){
					alert("입력하세요");
					return false;
				}else{
					return true;
				}
			});	
		});

		/*// wait for document to load
		$(function(){
		  
		  // use a different language
		  // $file prints the file name
		  // $ext prints the file extension
		
		  // invoke plugin
		  $('image').MultiFile({ 
			max: 3, 
			accept: 'gif|jpg|png'
			STRING: { 
			  remove:'Remover', 
			  selected:'Selecionado: $file', 
			  denied:'Invalido arquivo de tipo $ext!' 
			} 
		  });
		}); */


		/*//이미지 미리보기 (업로드를 안 하고 미리보기는 브라우저에서 지원을 안해서 동작 안됨)
		function setImageFromFile(input, expression) {
			if (input.files && input.files[0]) {

				var reader = new FileReader();
				reader.onload = function (e) {
					$(expression).attr('src', e.target.result);
					
				}
			reader.readAsDataURL(input.files[0]);
			}
		}

		$('#image').change(function(){
			setImageFromFile(this, '#preview');
			alert("error");
		});
		*/
	</script>
	
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
                vertical-align: top;
                border-bottom: 1px solid #ccc;
        }
        table.table2 td {
                 width: 100px;
                 padding: 10px;
                 vertical-align: top;
                 border-bottom: 1px solid #ccc;
        }
 
</style>
<body>

	<form id ="write_form" method = "post" action = "write_action.php" enctype='multipart/form-data' onsubmit="return check()">
	<table  style="padding-top:50px" align = "center" width=700 border=0 cellpadding=2 >
		<tr>
			<td height=20 align= center bgcolor=#ccc><font color=white> 글쓰기 </font></td>
		</tr>
		<tr>
			<td bgcolor=white>
				<table class = "table2">
					<tr>
						<td >작성자</td>
						<td><input type = "text" name = 'author' size=20> </td>
					</tr>

					<tr>
						<td >제목</td>
						<td><input type = "text" name = 'title' size=60></td>
					</tr>

					<tr>
						<td >내용</td>
						<td><textarea name = "context" cols=85 rows=15></textarea></td>
					</tr>

					<tr>
						<td >이미지</td>
						<!--<td><img src="" id="preview"/></td>-->
						<td><input type="file" name="image" id="image" value=""></td>
						<td >썸네일</td>
						<td ><input type="checkbox" name="thumbnail" value="1"></td>
					</tr>
				</table>
				<center>
				<input type = "submit" value="작성">
				</center>
			</td>
		</tr>
    </table>
    </form>

	

</body>
</html>
 