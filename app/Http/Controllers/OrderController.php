<?php 
	namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
class OrderController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
	function address(Request $request)
	{
      $response=auth()->user();
         $user_id=$response->id;
        $status=1;
        $arr=array('status'=>'0');
        DB::table('address')->where('status','=',$status)->update($arr);
         $address=$request->input('address');
         $name=$request->input('name');
          $detailedaddress=$request->input('detailedaddress');
        DB::table('address')->insert(['uid'=>$user_id,'address'=>$address,'status'=>$status,'name'=>$name,'detailedaddress'=>$detailedaddress]);
          $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
          echo $json=json_encode($res);  
	}
  function order(Request $request){
        $id=$request->input('id');
         $response=auth()->user();
         $user_id=$response->id;
        $hid=explode("-",$id);
        array_shift($hid);
        $h_id=implode($hid, "' or shopping_cate.id='");
            $arr = DB::select("select shopping_cate.id,shopping_cate.goods_id,shopping_cate.number,shopping_cate.uid,goods.name,shopping_cate.attribute_name,goods_prodcut.price from goods_prodcut join goods on  goods_prodcut.goods_id=goods.id join shopping_cate on goods_prodcut.id=shopping_cate.goods_id where shopping_cate.uid='$user_id' and shopping_cate.id='$h_id'");
        return response()->json($arr);
       
    }
    function ress(Request $request){
       $arr = DB::select("select * from address where status='1'");
          return response()->json($arr);
    }
    function addaction(Request $request){
       $response=auth()->user();
        $user_id=$response->id;
        $arrdess=$request->input('address');
        $id=$request->input('id');
        $hid=explode(',', $id);
        $time=date('Y-m-d H:i:s',time());
        $order_number = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
         DB::table('suborder')->insert(['time'=> $time,'uid'=>$user_id,'address'=>$arrdess,'status'=>'0','order_number'=>$order_number]);
         $order_id=DB::getPdo()->lastInsertId();
       for ($i=0; $i <count($hid)-1 ; $i++) { 
          $arr = DB::select("select shopping_cate.id,shopping_cate.goods_id,shopping_cate.number,shopping_cate.uid,goods.name,shopping_cate.attribute_name,goods_prodcut.price from goods_prodcut join goods on  goods_prodcut.goods_id=goods.id join shopping_cate on goods_prodcut.id=shopping_cate.goods_id where shopping_cate.id='$hid[$i]'");
          $h_id=$arr[0]->id;
          $hname=$arr[0]->name;
          $number=$arr[0]->number;
          $attribute_name=$arr[0]->attribute_name;
          $price=$arr[0]->price;
        DB::insert("INSERT INTO orderdetails (`h_id`,`h_goods`,`h_type`,`price`,`num`,`order_id`) VALUES ('$h_id','$hname','$attribute_name','$price','$number','$order_id')");
          
       }
          return response()->json($order_number);
    }
}
?>