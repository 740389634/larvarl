<!DOCTYPE html>
 <html>
 <head>
 	<meta name="csrf-token" content="{{ csrf_token() }}">
 	<title></title>
 </head>
 <body>
 	用户名：<input type="text" id="name">
 	<br>
 	密码：<input type="text" id="password">
 	<br>
 	<button onclick="login()">登录</button>
 	<span id="span"></span>
 </body>
 <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
</script>
<script type="text/javascript">
	function login(){
		var name=$('#name').val()
		var password=$('#password').val()
		$.ajax({
			url:"<?php echo url('user/add_login');?>",
			data:{
				 '_token': $('meta[name=csrf-token]').attr("content"),
				name:name,
				password:password
			},
			type:'post',
			dataType:'json',
			success:function(res){
				if (res.status=='error') {
					$('#span').html(res.data)
  					$('#span').css("color",'red')
  					setTimeout(function(){ 
		              $('#span').html('')
		             }, 3000);
				}
				if (res.status=='ok') {
					location.href='<?php echo url('user/test') ?>'
				}
			}
		})
		
	}
</script>
 </html>