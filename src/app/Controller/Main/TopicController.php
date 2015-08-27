<?php

namespace App\Controller\Main;

use App\Controller\Base;
use App\Model\TopicModel;
use App\Service\TopicService;
use App\Service\CommentService;
use App\Service\UserProfileService;
use App\Exception\ServiceException;

class TopicController extends Base
{

    //显示话题信息
    public function showAction()
    {
        $topicId = intval($this->get('id'));
        $page = max(1, intval($this->get('page')));
        $pageSize = 20;
        if ($topicId < 1) {
            return $this->message('话题ID错误');
        }

        try {
            $topic = TopicService::getTopicInfo($topicId);
        } catch (ServiceException $e) {
            return $this->message($e->getMessage());
        }

        $commentList = $headlines = array();
        $headlines[] = $topic['user_id'];
        if ($topic['comment_count'] > 0) {
            $commentList = CommentService::getListByTopicId($topicId, $page, $pageSize);
            $start = ($page - 1) * $pageSize;
            $userIds = array();
            foreach ($commentList as &$value) {
                $value['floor'] = ++$start;
                $userIds[] = $value['user_id'];
            }
            unset($value);
            $userIds = array_unique($userIds);
            $tmp = UserProfileService::getProfileByUserIds($userIds, array('headline'));
            foreach ($tmp as $value) {
                $headlines[$value['user_id']] = $value['headline'];
            }
            unset($tmp, $value, $userIds);
        }

        $this->setHeaderMetas($topic['title']);

        $this->assign(array(
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $topic['comment_count'],
            'topic' => $topic,
            'commentList' => $commentList,
            'headlines' => $headlines,
        ));
        $this->display();
    }

    //回复话题
    public function replyAction()
    {
        $this->checkLogin();

        $topicId = intval($this->get('topic_id'));
        $content = $this->get('reply_content');

        if (empty($topicId) || empty($content)) {
            return $this->message('请输入回复内容');
        }

        $content = preg_replace('/\n{3,}/', "\n\n", str_replace("\r", '', $content));
        $content = nl2br($content);

        try {
            CommentService::addComment($this->userId, $topicId, $content);
            return $this->redirect(URL('main/topic/show', array('id' => $topicId)));
        } catch (ServiceException $e) {
            return $this->message($e->getMessage());
        }
    }

    //跳转
    public function goAction()
    {
        $id = intval($this->get('id'));
        $topic = TopicModel::getInstance()->getTopicById($id);
        if (!$topic) {
            \App::abort(404);
            return false;
        }
        TopicModel::getInstance()->incrementField($id, 'view_count', 1);
        $this->redirect($topic['url']);
    }
}