<?php
namespace app\miniapp\controller;
use think\Request;
use think\Exception;
use think\Controller;
use app\miniapp\model\Comment as CommentModel;
use app\miniapp\server\Server;

/**
 * @return 评论所有相关
 */
class Comment extends Controller
{
	
	/**
	* @author 安国栋
	* @param a_id 文章id
	* @param u_id评论者id
	* @param contenet内容
	* @return 返回成功或者失败
	*
	*/	
	public function add(Request $request)
	{
		$a_id = $request->param('a_id');
		$u_id = $request->param('u_id');
		$content = $request->param('content');
		$comment = new CommentModel($a_id);
		$t_id = $request->param('t_id');
		if($t_id)
		{
			$res = $comment->add($u_id,$content,$t_id);
		}else{
			$res = $comment->add($u_id,$content);
		}
		if($res)
		{
			return Server::resolve($res,'评论成功',521);
		}
		return Server::resolve($res,'评论失败',1314);
	}
	/**
	* @author 安国栋
	* @param a_id
	* @return 返回该文章的评论列表
	*
	*/	
	public function list(Request $request)
	{
		$a_id = $request->post('a_id');
		$comment = new CommentModel($a_id);
		$res = $comment->get_list();
		if($res)
		{
			return Server::resolve($res,'获取列表成功',521);
		}
		return Server::resolve($res,'获取列表失败',1314);
	}


	public function remove(Request $request)
	{
		$id = $request->param('id');

		$token = $request->param('token');
		$u_id = Server::get_user_id($token)['id'];
		if(!$u_id)
		{
			return Server::resolve($u_id,'token失效',-1);
		}
		$comment = new CommentModel();
		$res = $comment->rm($id,$u_id);
		
		return Server::resolve($res,'删除成功',521);

	}

}



















