<?php

namespace App\Controller\Api;

use App\Controller\ApiBase;
use App\Service\TopicService;

class TopicController extends ApiBase
{
    public function init()
    {
        parent::init();
        $this->checkLogin();
    }

    public function voteAction()
    {
        $topicId = intval($this->get('id'));

        try {
            $votes = TopicService::vote($this->userId, $topicId);
            $this->assign('votes', $votes);
            $this->display();
        } catch (\Exception $e) {
            $this->message($e->getMessage());
        }

    }

    public function postAction()
    {
        $data = $this->get('data');
        $data['user_id'] = 1;
        $data['user_name'] = 'root';

        $topicId = TopicService::addTopic($data);

        $this->message('OK', MSG_OK);
    }

}
