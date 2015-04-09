<?php

namespace App\Model;

use Core\Model;

class UserProfileModel extends Model
{

    protected $tableName = '#table_user_profile';

    /**
     * 插入一条记录
     *
     * @param array $data
     * @return int ID
     */
    public function add(array $data)
    {
        return parent::insert($data);
    }

    /**
     * 根据用户ID获取一条记录
     *
     * @param $userId
     * @return array|false
     */
    public function getByUserId($userId)
    {
        return $this->getRow(array('user_id'=>$userId));
    }

    /**
     * 根据用户列表获取列表
     *
     * @param array $userIds
     * @param array $fields
     * @return array
     */
    public function getListByUserIds(array $userIds, array $fields)
    {
        return $this->select($fields, array('user_id'=>$userIds));
    }

    /**
     * 更新用户个人信息
     *
     * @param int $userId
     * @param array $update
     * @return int
     */
    public function updateProfile($userId, $update)
    {
        return $this->update($update, array('user_id' => $userId));
    }
}
