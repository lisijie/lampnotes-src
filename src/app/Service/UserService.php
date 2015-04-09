<?php

namespace App\Service;

use App\Model\UserModel;
use App\Model\VoteLogModel;

class UserService extends ServiceBase
{

    /**
     * 获取贡献前N名的用户
     *
     * @param $num
     * @return array
     */
    public static function getTopUser($num)
    {
        $fields = array('id', 'user_name', 'nick_name', 'score', 'topic_count');
        $list = UserModel::getInstance()->getTopUserByScore($num, $fields);

        return $list;
    }

    /**
     * 获取用户对一批话题的投票状态
     *
     * @param $userId
     * @param array $topicIds
     * @return array
     */
    public static function getTopicVoteStatus($userId, array $topicIds)
    {
        if (empty($topicIds)) return array();
        $topicIds = array_map('intval', $topicIds);

        $list = VoteLogModel::getInstance()->getVoteStatus($userId, $topicIds);
        $result = array();
        foreach ($list as $row) {
            $result[$row['topic_id']] = $row['vote_time'];
        }

        return $result;
    }
}