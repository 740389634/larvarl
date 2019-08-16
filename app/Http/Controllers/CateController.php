<?php 
		namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
class CateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['attribute','number']]);
    }
	 function shopping_cate(Request $request){

        $num=$request->input('num');

        $goods_id=$request->input('goods_id');

        $token=$request->input('token');
        $response=response()->json(auth()->user());
        $js=json_encode($response);
        $original=json_decode($js,true);
        $user_id=$original["original"]['id'];

        $name=$request->input('name');

        $attr_name=$request->input('attr_name');

        DB::insert("insert into shopping_cate(`uid`,`goods_id`,`number`,`attribute_name`) values('$user_id','$goods_id','$num','$attr_name')");
    }
    function buycar(Request $request){
         $token=$request->input('token');
         $response=auth()->user();
         $user_id=$response->id;
         $arr = DB::select("select shopping_cate.id,shopping_cate.goods_id,shopping_cate.number,shopping_cate.uid,goods.name,shopping_cate.attribute_name,goods_prodcut.price from goods_prodcut join goods on  goods_prodcut.goods_id=goods.id join shopping_cate on goods_prodcut.id=shopping_cate.goods_id where shopping_cate.uid='$user_id'");
        	return response()->json($arr);
    }
    function number(Request $request){
        $id=$request->input('id');
        $number=$request->input('number');
        $arr=array('number'=>$number);
        DB::table('shopping_cate')->where('id','=',$id)->update($arr);
    }
    
}
 ?>
