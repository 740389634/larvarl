<!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <body>
 	 <div id="div" style="display: none; border: 1px solid black;background-color: black; position: absolute;left: 45%;top: 40%;width: 185px;height:200px; background: rgba(0, 0, 0, 0.5)" >
      <input type="text" id="pid">
      <input type="text" id="pname">
      <input type="text" id="page">
      <button style="left: 100px" onclick="ookk()" >确认</button>
      <button style="left: 100px" onclick="cancel()">取消</button>
    </div>
 	用户：{{$name}}
 	<a href="<?php echo url("user/action_login") ?>">退出</a>
 	<table border="1">
 		
 	</table>
 	<input type="text" id="name">
 	<input type="text" id="age">
 	<button onclick="add()">添加</button>
 </body>
 <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
</script>
<script type="text/javascript">
	function show() {
		$.ajax({
			url:"<?php echo url('user/show');?>" ,
			dataType:'json',
			success:function(res){
				var data=res.data
				var tr='';
				for (var i = 0; i < data.length; i++) {
					tr=tr+"<tr><td>"+data[i].id+"</td><td>"+data[i].name+"</td><td>"+data[i].age+"</td><td><button onclick='mydelete("+data[i].id+")'>删除</button></td><td><button onclick='myupdate("+data[i].id+",\""+data[i].name+"\",\""+data[i].age+"\")'>修改</button></td></tr>"
				}
				$('table').html(tr)
			}
		})
	}
	show()
	function mydelete(id){
		$.ajax({
			url:"<?php echo url('user/delete');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				id:id
			},
			type:'post',
			dataType:'json',
			success:function(res){
				if (res.status=='ok') {
					show()
				}
				
				console.log(res)
			}
		})
	}
	function add(){
		var name=$('#name').val()
		var age=$('#age').val()
		$.ajax({
			url:"<?php echo url('user/addaction');?>",
			data:{
				'_token': $('meta[name=csrf-token]').attr("content"),
				name:name,
				age:age
			},
			type:'post',
			dataType:'json',
			success:function(res){
				if (res.status=='ok') {
					$('#name').val('')
					$('#age').val('')
					show()
				}
				if (res.status=='error') {
					alert(res.data)
				}
			}
		})
	}
	  function cancel(){
        $("#div").css("display","none");
      }
       function myupdate(id,name,age){
       	 $("#pid").val(id)
       	 $("#pname").val(name)
       	 $("#page").val(age)
        $("#div").css("display","block");
       
      }
     function ookk(){
        var id=$('#id').val()
        var name=$('name').val()
        var age=$('age').val()
        $.ajax({
        	url:"<?php echo url('user/update');?>",
        	data:{
        		'_token': $('meta[name=csrf-token]').attr("content"),
        		id:id,
        		name:name,
        		age:age
        	},
        	type:'post',
        	dataType:'json',
        	success:function(res){
        		console.log(res)
        	}
        })
    }
</script>
 </html>