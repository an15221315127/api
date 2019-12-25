<?php
namespace app\miniapp\model;
use think\Db;
use think\Model;

/**
 * \
 */
class Comment extends Model
{
	private $a_id;

	public function __construct($a_id = -1)
	{
		# code...
		$this->a_id = $a_id;
	}
	/**
	* @author 安国栋
	* @param t_id 被评论者id。非必传
	* @param u_id评论者id
	* @param contenet内容
	* @return 返回成功或者失败
	*
	*/	
	public function add($u_id,$contenet,$t_id = -1)
	{
		$data = [
			'u_id'=>$u_id,
			'a_id'=>$this->a_id,
			't_id'=>$t_id,
			'content'=>$contenet,
			'create_time'=>time(),
		];
		$res = Db::table('an_comment')->insertGetId($data);
		return $res;
	}
	/**
	* @author 安国栋
	* @param t_id 被评论者id。非必传
	* @param u_id评论者id
	* @param contenet内容
	* @return 返回成功或者失败
	*
	*/	
	public function get_list()
	{
		$res = Db::table('an_comment')
		->alias('c')
		->join('an_user u','c.u_id = u.id')
		->where('c.is_del','1')
		->field('c.u_id,c.t_id,c.content,c.create_time,u.avatarUrl,u.nickName')
		->order('c.create_time desc')
		->cache(true)
		->select();
		$arr = $res;
		foreach ($res as $key => $value) {
			# code...
			if($value['t_id'] > 0)
			{	
				$res[$key]['child'] = [];
				foreach ($arr as $k => $val) {
				# code...
					if($value['t_id'] === $val['u_id'])
					{
						array_push($res[$key]['child'],$val);
						
					}

				}
				
			}
			
		}
		return $res;
	}


	/**
	* @param 文章id $id 
	* @param 评论者id$u_id
	* @return 删除成功
	*
	*/
	public function rm($id,$u_id)
	{	

		$where = [
			'id'=>$id,
			'u_id'=>$u_id
		];
		$res = Db::table('an_comment')->where($where)->update(['is_del'=>2]);
	}
}




























