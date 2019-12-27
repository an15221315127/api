<?php
namespace app\index\controller;
use think\Controller;
use think\Request;


/**
 * 用户类
 */
class User extends Controller
{

	

	/**
	* @param username
	* @param password
	* @return userInfo
	*/
	login(Request $request){

		$username = $request->post('username');
		$password = $request->post('password');

			





	}
}
