<?php

namespace App\Controller\Main;

use App\Controller\Base;
use App\Exception\ServiceException;
use App\Service\TopicService;
use Core\Lib\Validate;

class SubmitController extends Base
{

    public function init()
    {
        parent::init();
        $this->checkLogin();
    }

    //投稿页面
    public function indexAction()
    {
        $this->setHeaderMetas('投递');
        $this->assign('errMsg', $this->session->getFlash('errMsg'));
        $this->display();
    }

    //提交投稿
    public function postAction()
    {
        $title = $this->get('title');
        $url = $this->get('url');
        $content = $this->get('content');

        if (empty($title)) {
            $this->flashMessage(array('errMsg' => '请填写标题'), 'main/submit/index');
        }
        if (empty($url) && empty($content)) {
            $this->flashMessage(array('errMsg' => 'URL和内容至少填写一个'), 'main/submit/index');
        }
        if (!empty($url) && !Validate::valid('url', $url)) {
            $this->flashMessage(array('errMsg' => 'URL无效'), 'main/submit/index');
        }

        $specialType = 0;
        if (strpos($title, '讨论：') === 0 || strpos($title, '讨论:') === 0) {
            $specialType = 1;
            if (empty($content)) {
                $this->flashMessage(array('errMsg' => '讨论贴内容不能为空'), 'main/submit/index');
            }
        } elseif (strpos($title, '招聘：') === 0 || strpos($title, '招聘:') === 0) {
            $specialType = 2;
            if (empty($content)) {
                $this->flashMessage(array('errMsg' => '招聘贴内容不能为空'), 'main/submit/index');
            }
        }

        if (!empty($content)) {
            $content = preg_replace('/\n{3,}/', "\n\n", str_replace("\r", '', $content));
            $content = nl2br($content);
        }

        try {
            $topicId = TopicService::addTopic(array(
                'title' => $title,
                'url' => $url,
                'content' => $content,
                'user_id' => $this->userId,
                'user_name' => $this->userName,
                'special_type' => $specialType,
            ));
        } catch (ServiceException $e) {
            $this->flashMessage(array('errMsg' => $e->getMessage()), 'main/submit/index');
        }

        $this->redirect(URL('main/topic/show', array('id' => $topicId)));
    }

}