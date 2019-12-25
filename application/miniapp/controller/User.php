<?php

namespace app\miniapp\controller;
use think\Request;
use think\Exception;
use think\Controller;
use app\miniapp\server\Server;
use app\miniapp\model\User as UserModel;


/**
 * @param 关于用户信息的一系列处理
 */
class User extends Controller
{
	// 获取配置文件里写好的appid
	private $appid; 
		// 获取配置文件里写好的secretId
	private $secretid;

	public function __construct()
	{
		# code...
		$this->appid = config('appId');
		$this->secretid = config('AppSecret');
	}
	
	/**
	* @param 前端传来的code
	* @method 私有的	
	* @return 用户的openid	
	*/
	private function get_openid($code)
	{
		//拼接好请求地址，并且携带好参数	
		$uri = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appid."&secret=".$this->secretid."&js_code=".$code."&grant_type=authorization_code";
		// 请求微信接口并且将返回值赋值
		$data = json_decode(file_get_contents($uri),true);

		return $data['openid'];
	}
	/**
	* @create_time 2019年11月24日
	* @author 安国栋
	* @param 前端传来的code和用户信息
	* @method post
	* @return 用户信息	
	*/
	public function login(Request $request)
	{	

		try {
			// 获取code
			$code = $request->post('code');

			if(empty($code)){
				// 抛出code为空的错误
				throw new Exception("this code is undefined", 1);
			}

		} catch (Exception $e) {
			return Server::resolve($e,'code没传',0);
		}

		// 获取openid
		$openid = $this->get_openid($code);

		$userInfo = $request->post('userInfo/a');
		// 根据是否传userInfo来进行相应的实例化对象
		if(isset($userInfo))
		{
			$data = new UserModel($openid,$userInfo);

		}else{
			$data = new UserModel($openid);
		}

		$res = $data->login();
		
		return Server::resolve($res,'登陆成功',521);

	}
}