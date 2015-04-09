<?php

namespace App\Service;

use \App;
use App\Exception\ServiceException;
use Core\Lib\String;
use Core\Lib\Password;
use Core\Lib\Validate;
use App\Model\UserModel;
use App\Model\UserProfileModel;

class UserAccountService extends ServiceBase
{
	//用户名最小长度
	const USER_NAME_MIN_LEN = 3;
	//用户名最大长度
	const USER_NAME_MAX_LEN = 15;
	//Email最大长度
	const EMAIL_MAX_LEN = 50;
    //密码最小长度
    const PASSWORD_MIN_LEN = 6;

	//使用用户名登录
	const LOGIN_BY_USERNAME = 1;
	//使用Email登录
	const LOGIN_BY_EMAIL = 2;

	//-----错误号声明-----
	const ERRCODE_NO_ACTIVE = 1; //未激活

	public static function register($userName, $password, $email)
	{
		//验证用户名
		if (empty($userName)) {
			throw new ServiceException('用户名不能为空');
		}
		if (!Validate::valid('/^[a-z0-9][a-z0-9_]{'.(self::USER_NAME_MIN_LEN-1).','.(self::USER_NAME_MAX_LEN-1).'}/i', $userName)) {
			throw new ServiceException('用户名不合法');
		}

		//验证Email
		if (!isset($email)) {
			throw new ServiceException('Email不能为空');
		}
		if (!Validate::valid('email', $email)) {
			throw new ServiceException('Email无效');
		}
		if (String::len($email) > self::EMAIL_MAX_LEN) {
			throw new ServiceException('Email长度不能大于'.self::EMAIL_MAX_LEN.'字符');
		}

        //验证密码
        if (!isset($password)) {
            throw new ServiceException('密码不能为空');
        }
        if (String::len($password) < self::PASSWORD_MIN_LEN) {
            throw new ServiceException('密码长度必须在6个字符以上');
        }

		$userModel = UserModel::getInstance();

		//检查用户是否已存在
		if ($userModel->checkUserName($userName) || $userModel->checkNickName($userName)) {
			throw new ServiceException('用户名已存在');
		}
		//检查Email是否已存在
		if ($userModel->checkEmail($email)) {
			throw new ServiceException('Email已存在');
		}

		$salt = String::random(10);
		$user = array(
			'user_name' => $userName,
			'nick_name' => $userName,
			'email' => $email,
			'password' => Password::hash($password, $salt),
			'salt' => $salt,
			'reg_time' => NOW,
            'active' => 0,
			'reg_ip' => ip2long(App::getRequest()->getClientIp()),
		);

		$userId = $userModel->addUser($user);
		$profileModel = UserProfileModel::getInstance();
		$profileModel->add(array('user_id'=>$userId));

		return $userId;
	}

	/**
	 * 用户登录
	 *
	 * @param string $account 帐号
	 * @param string $password 密码
	 * @param int $expire 有效期/秒
	 * @param int $type 登录类型
	 * @return bool
     * @throws ServiceException
	 */
    public static function login($account, $password, $expire = 0, $type = self::LOGIN_BY_USERNAME)
	{
		$userModel = UserModel::getInstance();
		switch ($type) {
			case self::LOGIN_BY_USERNAME:
				if (empty($account) || !Validate::username($account)) {
					throw new ServiceException('用户名无效');
				}
				$user = $userModel->getByUserName($account);
				break;
			case self::LOGIN_BY_EMAIL:
				if (empty($account) || !Validate::valid('email', $account)) {
					throw new ServiceException('Email无效');
				}
				$user = $userModel->getByEmail($account);
				break;
			default:
				throw new ServiceException('登录类型无效:'.$type);
		}

		if (empty($user)) {
			throw new ServiceException('用户不存在');
		}
		if (Password::hash($password, $user['salt']) != $user['password']) {
			throw new ServiceException('密码错误');
		}
		if (!$user['active']) {
			//throw new ServiceException('用户未激活', self::ERRCODE_NO_ACTIVE);
		}

        UserCookieService::setLoginCookie($user, $expire);

		$update = array(
			'last_ip' => ip2long(App::getRequest()->getClientIp()),
			'last_login' => NOW,
			'login_count' => $user['login_count'] + 1,
		);
		$userModel->updateUser($user['id'], $update);

		return true;
	}

    /**
     * 修改密码
     *
     * @param int $userId
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool
     * @throws ServiceException
     */
    public static  function changePassword($userId, $oldPassword, $newPassword)
    {
        if (empty($userId) || !is_numeric($userId)) {
            throw new ServiceException('用户ID无效');
        }
        if (empty($oldPassword)) {
            throw new ServiceException('当前密码不能为空');
        }
        if (empty($newPassword)) {
            throw new ServiceException('新密码不能为空');
        }
        if ($oldPassword == $newPassword) {
            throw new ServiceException('新密码不能跟当前密码一致');
        }
        if (String::len($newPassword) < self::PASSWORD_MIN_LEN) {
            throw new ServiceException('密码长度必须在6个字符以上');
        }

        $userModel = UserModel::getInstance();
        $userInfo = $userModel->getById($userId);
        if (empty($userInfo)) {
            throw new ServiceException('用户不存在:'.$userId);
        }
        if ($userInfo['password'] != Password::hash($oldPassword, $userInfo['salt']))
        {
            throw new ServiceException('当前密码错误');
        }
        $update = array(
            'password' => Password::hash($newPassword, $userInfo['salt']),
        );
        $userModel->updateUser($userId, $update);
        return true;
    }

    /**
     * 更新话题数
     *
     * @param int $userId 用户ID
     * @param int $value 增加值
     * @return int
     */
    public static function updateTopicCount($userId, $value = 1)
    {
        $userModel = UserModel::getInstance();
        return $userModel->incrementField(intval($userId), 'topic_count', $value);
    }

    /**
     * 更新回复数
     *
     * @param int $userId 用户ID
     * @param int $value 增加值
     * @return int
     */
    public static function updateCommentCount($userId, $value = 1)
    {
        $userModel = UserModel::getInstance();
        return $userModel->incrementField(intval($userId), 'comment_count', $value);
    }

    /**
     * 更新收藏数
     *
     * @param int $userId 用户ID
     * @param int $value 增加值
     * @return int
     */
    public static function updateFavCount($userId, $value = 1)
    {
        $userModel = UserModel::getInstance();
        return $userModel->incrementField(intval($userId), 'fav_count', $value);
    }

    /**
     * 获取用户信息
     *
     * @param int $userId
     * @return array
     * @throws ServiceException
     */
    public static function getUserInfo($userId)
    {
        $userId = intval($userId);
        $userModel = UserModel::getInstance();
        $userInfo = $userModel->getById($userId);
        if (empty($userInfo)) {
            throw new ServiceException('用户不存在:'.$userId);
        }
        return $userInfo;
    }

    /**
     * 获取用户信息
     *
     * @param string $userName
     * @return array
     * @throws ServiceException
     */
    public static function getUserInfoByUserName($userName)
    {
        $userModel = UserModel::getInstance();
        $userInfo = $userModel->getByUserName($userName);
        if (empty($userInfo)) {
            throw new ServiceException('用户不存在:'.$userName);
        }
        return $userInfo;
    }

    public static function updateScore($userId, $type)
    {
        $config = App::conf('setting', 'score');
        $config = $config['user'];
        if (!isset($config[$type])) {
            throw new \InvalidArgumentException('类型无效: ' . $type);
        }
        return UserModel::getInstance()->incrementField(intval($userId), 'score', intval($config[$type]));
    }
}
