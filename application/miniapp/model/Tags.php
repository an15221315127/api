<?php
namespace app\miniapp\model;
use think\Model;
use think\Db;

/**
 * 
 */
class Tags extends Model
{
	/**
	* @param title 标签名
	* @return 返回添加成功或者失败
	*/
	public function add($title,$u_id)
	{
		$data = [
			'title'=>$title,
			'create_time'=>time(),
			'status'=>1,
			'u_id'=>$u_id
		];
		$res = Db::table('an_tags')->insertGetId($data);
		return $res;
	}
	/**
	* @param 无
	* @return 当前标签列表
	*/
	public function tags()
	{
		$res = Db::table('an_tags')->where('status',1)->field('u_id',true)->order('create_time desc')->select();
		return $res;
	}
	

}