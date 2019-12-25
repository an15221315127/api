<?php
namespace app\miniapp\controller;
use think\Request;
use think\Exception;
use think\Controller;
use app\miniapp\model\Tags as TagsModel;
use app\miniapp\server\Server;



/**
 * @author 安国栋
 */
class Tags extends Controller
{
	/**
	* @param title标签名
	* @param token
	* @return 返回成功或者失败	
	*/
	public function add_tags(Request $request)
	{
		$title = $request->param('title');
		$token = $request->param('token');
		$u_id = Server::get_user_id($token)['id'];
		if(!$u_id)
		{
			return Server::resolve($u_id,'token失效',-1);
		}
		$Tags = new TagsModel();
		$res = $Tags->add($title,$u_id);
		if($res)
		{
			return Server::resolve($res,'添加成功',521);
		}
		return Server::resolve($res,'添加失败',1314);
	}

	/**
	* @param 无
	* @return 返回成功或者失败	
	*/
	public function list_tags()
	{
		$tags = new TagsModel();
		$res = $tags->tags();
		if($res)
		{
			return Server::resolve($res,'获取列表成功',521);
		}
		return Server::resolve($res,'获取列表失败',1314);
	}
}





















