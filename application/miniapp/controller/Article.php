<?php
namespace app\miniapp\controller;
use app\miniapp\model\Article as ArticleModel;
use think\Request;
use think\Exception;
use think\Controller;
use app\miniapp\server\Server;


/**
 * 
 */
class Article extends Controller
{

	/**
	* @author 安国栋
	* @param 作者名author必传
	* @param a_id作者id必传
	* @param title标题必传	
	* @param content必传
	* @param banner图 非必传
	* @param tags 数组
	* @return 返回成功或者失败
	*
	*/	

	public function add(Request $request)
	{


		// 获取必传参数
		try {
			$author = $request->post('author');
			$token = $request->post('token');
			$tags = $request->post('tags/a');
			$a_id = Server::get_user_id($token)['id'];
			if(!$a_id)
			{
				return Server::resolve($a_id,'token失效',-1);
			}
			$title = $request->post('title');
			$content = $request->post('content');
			if(empty($author))
			{
				throw new Exception("author is undefined", 1);
				
			}else if (empty($a_id))
			{
				# code...
				throw new Exception("id is undefined", 2);
				
			}else if(empty($title))
			{
				throw new Exception("title is undefined", 2);
			}else if(empty($content))
			{
				throw new Exception("content is undefined", 2);
			}
			
		} catch (Exception $e) {
			return Server::resolve($e,'参数不全',-1);
		}
		// banner为非必传参数
		$banner = $request->post('banner');

		$article = new ArticleModel();
		
		if(empty($banner))
		{
			$data = $article->add($author,$a_id,$title,$content,$tags);
		}else{
			$data = $article->add($author,$a_id,$title,$content,$banner,$tags);
		}

		return Server::resolve($data,'添加成功',521);
		

	}
	/**
	* @author 安国栋
	* @param id.必传
	* @return 返回成功或者失败
	*
	*/	
	public function delete(Request $request)
	{
		$id = $request->post('id');
		$token = $request->post('token');
		$a_id = Server::get_user_id($token)['id'];
		if(!$a_id)
		{
			return Server::resolve($a_id,'token失效',-1);
		}
		if(empty($id))
		{
			return Server::resolve($id,'id.必传',0);
		}
		$article = new ArticleModel();
		$res = $article->remove($id);

		return Server::resolve($res,'删除成功',521);

	}
	/**
	* @author 安国栋
	* @param 文章id必传
	* @param title标题非必传
	* @param content非必传
	* @param banner图 非必传
	* @return 返回成功或者失败
	*
	*/	
	public function edit(Request $request)
	{
		$id = $request->post('id');
		$token = $request->post('token');
		$a_id = Server::get_user_id($token)['id'];
		if(!$a_id)
		{
			return Server::resolve($a_id,'token失效',-1);
		}
		$title = $request->post('title');
		$content = $request->post('content');
		$banner = $request->post('banner');
		$article = new ArticleModel();
		$res = $article->update_article($id,$title,$content,$banner);
		if($res)
		{
			return Server::resolve($res,'更新成功',521);
		}
		return Server::resolve($res,'更新失败',1314);
	}
	/**
	* @author 安国栋
	* @param 无
	* @return 文章列表
	*
	*/	

	public function lists()
	{
		$article = new ArticleModel();
		$res = $article->getList();
		if($res)
		{
			return Server::resolve($res,'获取列表成功',521);
		}
		return Server::resolve($res,'获取列表失败',1314);
	}



	/**
	* @author 安国栋
	* @param 无
	* @return 文章列表
	*
	*/	
	public function detail(Request $request)
	{
		$id = $request->post('id');
		
		$article = new ArticleModel();
		$res = $article->detail($id);
		if($res)
		{
			return Server::resolve($res,'获取详情成功',521);
		}
		return Server::resolve($res,'获取详情失败',1314);
	}
}




































