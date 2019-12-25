<?php
namespace app\miniapp\model;
use think\Model;
use think\Db;

/**
 * 
 */
class User extends Model
{	
	private $openid; // 保存openid
	private $userInfo; // 保存用户信息

	/**
	* @author 安国栋
	* @method 公共访问
	* @param  openid和用户信息
	* @return 构造函数
	*/

	public function __construct($openid,$userInfo = [])
	{
		# code...
		$this->openid = $openid;
		$this->userInfo = $userInfo;
	}

	/**
	* @author 安国栋
	* @method 私有的
	* @param  无
	* @return 组装用来更新的数据
	*/
	private function param()
	{
		
		$this->userInfo['update_time'] = time();
		$this->userInfo['token'] = md5($this->openid.time());
	}
	

	/**
	* @param 无
	* @return 查找用户信息	
	*/
	private function search()
	{
		$user = Db::table('an_user')->where('openid',$this->openid)->field('openid',true)->find();
		return $user;
	}


	/**
	* @param 无
	* @return 登陆入口
	*/
	public function login()
	{
		// 先去看是否是新用户
		$user = $this->search();
		$this->param();
		// 如果是，就先创建一个用户并返回用户基本信息
		if(empty($user))
		{	

			/**
			* @param 首次进入小程序会保留openid和创建时间后面则不再需要
			*/
			$this->userInfo['create_time'] = time();
			$this->userInfo['openid'] = $this->openid;
			
			Db::table('an_user')->insert($this->userInfo);
			return $this->search();
		}
		
		// 第二次以后的登陆
		Db::table('an_user')->where('openid',$this->openid)->update($this->userInfo);
		return $this->search();
		
	}
	
}