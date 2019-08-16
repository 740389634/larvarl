<?php 
	namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['show1','goods','product','shopping','area']]);
    }
	function tree($arr,$pid=0,$level=0)
	{
	$list = [];
        foreach ($arr as $k=>$v){
            if ($v->pid == $pid){
                $v->src=$level;
                $v->sos = $this->tree($arr,$v->id,$level+1);
                $list[] = $v;
        }
    }
    return $list;
	}
    function show1(){
    	$arr = DB::select('select * from goods_cate');
        $a=$this->tree($arr);
         return response()->json($a);
    }
    function goods(){
    	$arr = DB::select('select brand.id as brand_id,brand.brand_name, goods.id as g_id,goods.`name`as g_name from goods_floor join goods on goods_floor.goods_id=goods.id join brand on goods_floor.brand_id=brand.id');
    	$array=[];
    	foreach ($arr as $key => $value) {
    		$brand_name=$value->brand_name;
    		$brand_id=$value->brand_id;
    		$array[$brand_id][$brand_name][]=$value;
    	}
    	return response()->json($array);
    }
    function product(Request $request){
        $id=$request->input('id');
        $arr=DB::select("select goods.name,attr_details.name as d_name,attr_details.id,attribute.name as b_name,attr_details.attr_id as d_id,attribute.id as b_id from goods_attr inner join goods on goods_attr.goods_id=goods.id inner join attribute on goods_attr.attr_id=attribute.id inner join attr_details on goods_attr.attr_details_id=attr_details.id where goods_attr.goods_id='$id'");
        $attr=[];
        foreach ($arr as $key => $value){
            $attr[$value->b_name][]=[$value->d_name,$value->id];
        }
        $ass['name']=$arr[0]->name;
        $ass['data']=$attr;
        return response()->json($ass);
        
    }
    function shopping(Request $request){
         $id=$request->input('id');
         $aid=substr($id, 1);
         $gid=$request->input('uid');
         $arr=DB::select("select * from goods_prodcut where goods_id='$gid' and goods_attr_id='$aid'");
         return response()->json($arr);
    }
    function area(Request $request){
         $pid=$request->input('pid');
        $arr=DB::select("select * from `area` where parent_id='$pid'");
         return response()->json($arr);
    }
}
 ?>
