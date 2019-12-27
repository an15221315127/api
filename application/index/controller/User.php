<?php
namespace app\index\controller;
use think\Controller;
use think\Request;


/**
 * 用户类
 */
class User extends Controller
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
