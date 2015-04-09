<?php

namespace App\Controller\Main;

use App\Controller\Base;
use App\Service\SiteService;
use App\Service\TopicService;
use App\Service\UserService;

class MainController extends Base
{

    public function init()
    {
        parent::init();
        $this->assign(array(
            'topUsers'  => UserService::getTopUser(20),
            'topSites'  => SiteService::getTopList(10),
        ));
    }

    //首页，默认按热门排序
	public function indexAction()
	{
        $page = max(1, intval($this->get('page')));
        $pageSize = static::PAGE_SIZE;
        $total = 0;
		$this->setHeaderMetas();
		$list = TopicService::getHotTopicList($page, $pageSize, $total);

        $voteList = array();
        if ($this->userId > 0) {
            $topicIds = array();
            foreach ($list as $row) {
                $topicIds[] = $row['id'];
            }
            $voteList = UserService::getTopicVoteStatus($this->userId, $topicIds);
        }

		$this->assign(array(
            'voteList'  => $voteList,
			'topics'    => $list,
            'page'      => $page,
            'pageSize'  => $pageSize,
            'total'     => $total,
		));

		$this->display();
	}

    //最新发布的列表
    public function newestAction()
    {
        $this->setHeaderMetas('最新');
        $page = max(1, intval($this->get('page')));
        $pageSize = static::PAGE_SIZE;
        $total = 0;

        $list = TopicService::getNewTopicList($page, $pageSize, $total);

        $voteList = array();
        if ($this->userId > 0) {
            $topicIds = array();
            foreach ($list as $row) {
                $topicIds[] = $row['id'];
            }
            $voteList = UserService::getTopicVoteStatus($this->userId, $topicIds);
        }

        $this->assign(array(
            'voteList'  => $voteList,
            'topics'    => $list,
            'page'      => $page,
            'pageSize'  => $pageSize,
            'total'     => $total,
        ));

        $this->display('main/main/index');
    }

    //最新讨论列表
    public function discussAction()
    {
        $this->setHeaderMetas('讨论');
        $page = max(1, intval($this->get('page')));
        $pageSize = static::PAGE_SIZE;
        $total = 0;

        $list = TopicService::getSpecialTopicList(1, $page, $pageSize, $total);

        $voteList = array();
        if ($this->userId > 0) {
            $topicIds = array();
            foreach ($list as $row) {
                $topicIds[] = $row['id'];
            }
            $voteList = UserService::getTopicVoteStatus($this->userId, $topicIds);
        }

        $this->assign(array(
            'voteList'  => $voteList,
            'topics'    => $list,
            'page'      => $page,
            'pageSize'  => $pageSize,
            'total'     => $total,
        ));

        $this->display('main/main/index');
    }

    //最新招聘列表
    public function jobsAction()
    {
        $this->setHeaderMetas('招聘');
        $page = max(1, intval($this->get('page')));
        $pageSize = static::PAGE_SIZE;
        $total = 0;

        $list = TopicService::getSpecialTopicList(2, $page, $pageSize, $total);

        $voteList = array();
        if ($this->userId > 0) {
            $topicIds = array();
            foreach ($list as $row) {
                $topicIds[] = $row['id'];
            }
            $voteList = UserService::getTopicVoteStatus($this->userId, $topicIds);
        }

        $this->assign(array(
            'voteList'  => $voteList,
            'topics'    => $list,
            'page'      => $page,
            'pageSize'  => $pageSize,
            'total'     => $total,
        ));

        $this->display('main/main/index');
    }
}