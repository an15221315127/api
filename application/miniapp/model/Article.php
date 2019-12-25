<?php
namespace app\miniapp\model;
use think\Model;
use think\Db;

/**
 * 
 */
class Article extends Model
{
	
	

	/**
	* @author 安国栋
	* @param $author,$a_id,$title,$content,$banner
	* @return 添加成功后返回添加的id
	*
	*/

	public function add($author,$a_id,$title,$content,$banner=[])
	{
		$data = [
			'author'=>$author,
			'a_id' =>$a_id,
			'title'=>$title,
			'content'=>$content,
			'banner' =>$banner,
			'create_time'=>time(),
			'update_time'=>time(),
			'tags'=>$tags
		];
		$res = Db::table('an_article')->insertGetId($data);
		return $res;
	}
	/**
	* @author 安国栋
	* @param $id.$data
	* @return 删除和编辑底层其实都是更新字段，在这里将他封装
	*
	*/
	private function edit($id,$data)
	{
		$res = Db::table('an_article')->where('id',$id)->update($data);
		return $res;
	}
	/**
	* @author 安国栋
	* @param $id
	* @return 软删除，只将status状态修改
	*
	*/

	public function remove($id)
	{

		$res = $this->edit($id,['status'=>0,'update_time'=>time()]);
		return $res;
	}
	/**
	* @author 安国栋
	* @param $id,$title,$content,$banner
	* @return 更新后返回1为成功0为失败
	*
	*/

	public function update_article($id,$title,$content,$banner)
	{
		$data = [
			'id'=>$id,
			'title'=>$title,
			'content'=>$content,
			'banner'=>$banner,
			'update_time'=>time(),
			'status'=>1,

		];
		$res = $this->edit($id,$data);
		return $res;
		
	}
	/**
	* @author 安国栋
	* @param 无
	* @return 返回列表
	*
	*/
	public function getList()
	{
		$res = Db::table('an_article')->where('status','1')->order('create_time desc')->select();
		foreach ($res as $key => $value) {
			# code...
			 $res[$key]['create_time'] = date('Y-m-d',$value['create_time']);
			 $res[$key]['update_time'] = date('Y-m-d',$value['update_time']);
		}
		return $res;
		
	}
	/**
	* @author 安国栋
	* @param id
	* @return 返回文章详情
	*
	*/
	public function detail($id)
	{
		$res = Db::table('an_article')->where(['status'=>'1','id'=>$id])->find();
		return $res;
	}

}











