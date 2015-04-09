<?php

namespace App\Service;

use Core\Lib\Validate;
use App\Exception\ServiceException;
use App\Model\UserProfileModel;

class UserProfileService extends ServiceBase
{

	/**
	 * 获取用户个人资料
	 *
	 * @param int $userId
	 * @return array
	 * @throws ServiceException
	 */
	public static function getUserProfile($userId)
	{
		$userId = intval($userId);
		$profileModel = UserProfileModel::getInstance();
		$userProfile = $profileModel->getByUserId($userId);
		if (empty($userProfile)) {
			throw new ServiceException('用户个人信息不存在:'.$userId);
		}

		return $userProfile;
	}

    /**
     * 更新用户资料
     *
     * @param $userId
     * @param array $data
     * @return int
     * @throws \App\Exception\ServiceException
     */
    public static function updateUserProfile($userId, array $data)
	{
		$fields = array('gender','birthday', 'headline','city_name','address','zipcode','homepage','resume','qq','wechat','weibo');
		foreach ($data as $key => $val) {
			if (!in_array($key, $fields)) {
				unset($data[$key]);
			}
		}

		if (isset($data['gender']) && !in_array($data['gender'], array(0,1,2))) {
			throw new ServiceException('性别无效');
		}
		if (!empty($data['birthday']) && !Validate::valid('date', $data['birthday'])) {
			throw new ServiceException('生日无效');
		}
		if (!empty($data['zipcode']) && !Validate::valid('zipcode', $data['zipcode'])) {
			throw new ServiceException('邮编无效');
		}
		if (!empty($data['homepage']) && !Validate::valid('url', $data['homepage'])) {
			throw new ServiceException('个人主页无效');
		}
		if (!empty($data['qq']) && !Validate::valid('qq', $data['qq'])) {
			throw new ServiceException('QQ号码无效');
		}
		if (!empty($data['wechat']) && !Validate::valid('varname', $data['wechat'])) {
			throw new ServiceException('微信号无效');
		}
		if (!empty($data['weibo']) && !Validate::valid('url', $data['weibo'])) {
			throw new ServiceException('微博地址无效');
		}

		$data['update_time'] = NOW;

		$userId = intval($userId);
		$profileModel = UserProfileModel::getInstance();
		return $profileModel->updateProfile($userId, $data);
	}

    /**
     * 根据用户ID获取用户资料列表
     *
     * @param array $userIds
     * @param array $fields
     * @return array
     */
    public static function getProfileByUserIds(array $userIds, array $fields)
    {
        if (empty($userIds) || empty($fields)) {
            return array();
        }
        if (!in_array('user_id', $fields)) {
            $fields[] = 'user_id';
        }
        $userIds = array_map('intval', $userIds);
        $profileModel = UserProfileModel::getInstance();
        $list = $profileModel->getListByUserIds($userIds, $fields);
        $result = array();
        foreach ($list as $row) {
            $result[$row['user_id']] = $row;
        }
        return $result;
    }
}