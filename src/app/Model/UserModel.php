<?php
namespace App\Model;

use Core\Model;

class UserModel extends Model
{

    protected $tableName = '#table_user';

    public function addUser($data)
    {
        return $this->insert($data);
    }

    /**
     * 检查用户名是否存在
     *
     * @param string $userName
     * @return bool 存在返回true,否则返回false
     */
    public function checkUserName($userName)
    {
        if ($this->getRow(array('user_name' => $userName))) {
            return true;
        }
        return false;
    }

    /**
     * 检查昵称是否存在
     *
     * @param string $nickName
     * @return bool 存在返回true,否则返回false
     */
    public function checkNickName($nickName)
    {
        if ($this->getRow(array('nick_name' => $nickName))) {
            return true;
        }
        return false;
    }

    /**
     * 检查Email是否已存在
     *
     * @param string $email
     * @return bool 存在返回true,否则返回false
     */
    public function checkEmail($email)
    {
        if ($this->getRow(array('email' => $email))) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户名获取一条记录
     *
     * @param string $userName
     * @return array|false
     */
    public function getByUserName($userName)
    {
        return $this->getRow(array('user_name'=>$userName));
    }

    /**
     * 根据用户ID获取一条记录
     *
     * @param $userId
     * @return array|false
     */
    public function getById($userId)
    {
        return $this->getRow(array('id'=>$userId));
    }

    /**
     * 根据Email获取一条记录
     *
     * @param string $email
     * @return array|false
     */
    public function getByEmail($email)
    {
        return $this->getRow(array('email'=>$email));
    }

    /**
     * 更新用户信息
     *
     * @param int $userId
     * @param array $update
     * @return int
     */
    public function updateUser($userId, $update)
    {
        return $this->update($update, array('id' => $userId));
    }

    /**
     * 自增
     *
     * @param $id
     * @param $field
     * @param int $value
     * @return int
     */
    public function incrementField($id, $field, $value = 1)
    {
        $value = intval($value);
        $sql = "UPDATE {$this->tableName} SET `{$field}` = `{$field}` + {$value} WHERE id = " . intval($id);
        return $this->db->execute($sql);
    }

    /**
     * 获取积分排名前N个用户
     *
     * @param $num
     * @param array $fields
     * @return array
     */
    public function getTopUserByScore($num, $fields = array())
    {
        return $this->select($fields, array(), array('score'=>'desc'), $num);
    }
}