<?php

namespace App\Service;

use \App;
use App\Exception\ServiceException;
use App\Model\TopicModel;
use App\Model\CommentModel;

class CommentService extends ServiceBase
{
    const PAGE_SIZE = 20;

    /**
     * 添加回复
     *
     * @param int $userId
     * @param int $topicId
     * @param int $content
     * @return int 回复ID
     * @throws ServiceException
     */
    public static function addComment($userId, $topicId, $content)
    {
        if (empty($topicId) || empty($content)) {
            throw new ServiceException('参数无效');
        }
        $topicId = intval($topicId);
        $topicModel = TopicModel::getInstance();
        $topic = $topicModel->getTopicById($topicId);
        if (!$topic) {
            throw new ServiceException('话题不存在:' . $topicId);
        }
        $userInfo = UserAccountService::getUserInfo($userId);
        //插入回复数据
        $data = array(
            'topic_id' => $topic['id'],
            'user_id' => $userInfo['id'],
            'user_name' => $userInfo['user_name'],
            'content' => $content,
            'post_time' => NOW,
            'ip' => ip2long(App::getRequest()->getClientIp()),
        );
        //插入评论
        $commentModel = CommentModel::getInstance();
        $commentId = $commentModel->add($data);
        //更新话题信息
        $topicModel->updateTopic($topicId, array(
            'update_time' => NOW,
        ));
        $topicModel->incrementField($topicId, 'comment_count');

        //用户回复数+1
        UserAccountService::updateCommentCount($userId, 1);

        return $commentId;
    }

    /**
     * 获取某个主题的回复列表
     *
     * @param int $topicId
     * @param int $page
     * @param int $pageSize
     * @return array
     */
    public static function getListByTopicId($topicId, $page, $pageSize = self::PAGE_SIZE)
    {
        $topicId = intval($topicId);
        if ($topicId < 1) {
            return array();
        }
        $list = CommentModel::getInstance()->getListByTopicId($topicId, $page, $pageSize);

        return $list;
    }

}