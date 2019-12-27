<?php
namespace app\miniapp\controller;
use think\Request;
use think\Exception;
use think\Controller;
use app\miniapp\server\Server;



/**
 * 
 */
class Text extends Controller
{
	
	public function login_post(Request $request){


			$param = $request->post();

			return Server::resolve($param,'连接通过',1);
	}
	public function login_get(Request $request){


			$param = $request->get();

			return Server::resolve($param,'连接通过',1);
	}
}