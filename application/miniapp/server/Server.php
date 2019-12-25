<?php
namespace app\miniapp\server;
use think\Db;


/**
 * 
 */
class Server
{
	
	/**
	* @method 公共的静态方法
	* @param $data
	* @param @code
	* @param @msg
	* @return json数据	
	*/
	static public function resolve($data=[],$msg='平常愿意为您效劳',$code=521)
	{	
		$data = [
			'code'=>$code,
			'data'=>$data,
			'msg'=>$msg
		];
		return $data;
	}



	static public function get_user_id($token)
	{	
		$res = Db::table('an_user')->where('token',$token)->find();
		return $res;
	}
}