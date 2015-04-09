<?php

namespace App\Service;

use App\Model\SiteModel;
use App\Model\TopicModel;
use App\Model\UrlModel;
use App\Exception\ServiceException;
use App\Model\VoteLogModel;

class TopicService extends ServiceBase
{

    /**
     * 添加话题
     *
     * @param $data
     * @return int
     * @throws ServiceException
     */
    public static function addTopic($data)
    {
        if (!isset($data['create_time'])) {
            $data['create_time'] = NOW;
        }
        $data['update_time'] = NOW;
        $data['hot_score'] = self::getHotScore(NOW, 0, 0);
        $data['site_id'] = 0;

        $urlModel = UrlModel::getInstance();
        if (!empty($data['url'])) {
            $topicIds = $urlModel->getTopicIdsByHash(crc32($data['url']));
            if ($topicIds) {
                $lst = TopicModel::getInstance()->getTopicListByIds($topicIds, array('url'));
                foreach ($lst as $row) {
                    if ($row['url'] == $data['url']) {
                        throw new ServiceException('文章已投递过了');
                    }
                }
            }
            $domain = static::getDomain($data['url']);
            $site = SiteModel::getInstance()->getByDomain($domain);
            if (!$site) {
                $data['site_id'] = SiteModel::getInstance()->add(array('domain' => $domain));
            } else {
                $data['site_id'] = $site['id'];
            }
        }

        $topicId = TopicModel::getInstance()->addTopic($data);

        if (!$topicId) {
            throw new ServiceException('投递失败');
        }

        if (!empty($data['url'])) {
            $urlModel->add(crc32($data['url']), $topicId);
        }

        //更新分数
        UserAccountService::updateScore($data['user_id'], 'add_topic');
        //更新话题数
        UserAccountService::updateTopicCount($data['user_id'], 1);
        //更新站点话题数
        if ($data['site_id'] > 0) {
            SiteService::addTopicCount($data['site_id'], 1);
            SiteService::updateScore($data['site_id'], 'add_topic');
        }

        return $topicId;
    }

    /**
     * 获取热门话题列表
     *
     * @param $page
     * @param int $pageSize
     * @param int $total
     * @return array
     */
    public static function getHotTopicList($page, $pageSize, &$total)
    {
        $pageSize = max(0, min($pageSize, 100));
        $topicModel = TopicModel::getInstance();
        $list = $topicModel->getHotTopicList($page, $pageSize);
        if (!$total) $total = $topicModel->getTotalNum();
        foreach ($list as &$row) {
            $row['domain'] = static::getDomain($row['url']);
        }
        return $list;
    }

    /**
     * 获取最新话题列表
     *
     * @param int $page
     * @param int $pageSize
     * @param int $total
     * @return array
     */
    public static function getNewTopicList($page, $pageSize, &$total)
    {
        $pageSize = max(0, min($pageSize, 100));
        $topicModel = TopicModel::getInstance();
        $list = $topicModel->getNewTopicList($page, $pageSize);
        if (!$total) $total = $topicModel->getTotalNum();
        foreach ($list as &$row) {
            $row['domain'] = static::getDomain($row['url']);
        }
        return $list;
    }

    /**
     * 获取特殊话题列表
     *
     * @param $specialType
     * @param $page
     * @param $pageSize
     * @param $total
     * @return array
     */
    public static function getSpecialTopicList($specialType, $page, $pageSize, &$total)
    {
        $pageSize = max(0, min($pageSize, 100));
        $topicModel = TopicModel::getInstance();
        $list = $topicModel->getSpecialTopicList($specialType, $page, $pageSize);
        if (!$total) $total = $topicModel->getSpecialTotalNum($specialType);
        foreach ($list as &$row) {
            $row['domain'] = static::getDomain($row['url']);
        }
        return $list;
    }

    /**
     * 获取一个话题信息
     *
     * @param $topicId
     * @return array
     * @throws ServiceException
     */
    public static function getTopicInfo($topicId)
    {
        $topicModel = TopicModel::getInstance();
        $topicInfo = $topicModel->getTopicById($topicId);
        if (empty($topicInfo)) {
            throw new ServiceException('话题不存在');
        }
        $topicInfo['domain'] = static::getDomain($topicInfo['url']);

        return $topicInfo;
    }

    public static function getHotScore($time, $up, $down = 0)
    {
        if ($up < 1) return 0;
        $hours = ($time - strtotime('2015-02-07')) / 3600;
        $score = round($hours + ($up * log10($up) * 2));
        return $score;
    }

    /**
     * 投票
     *
     * @param $userId
     * @param $topicId
     * @return int 返回票数
     * @throws ServiceException
     */
    public static function vote($userId, $topicId)
    {
        if (!is_numeric($userId) || !is_numeric($topicId)) {
            throw new ServiceException('参数类型错误');
        }

        $topic = static::getTopicInfo($topicId);
        if (!$topic) {
            throw new ServiceException('话题不存在');
        }
        $topic['up_count']++;

        //检查是否投过票
        if (VoteLogModel::getInstance()->get($topicId, $userId)) {
            throw new ServiceException('你已经投过票了');
        }

        //添加投票日志
        VoteLogModel::getInstance()->add(array(
            'topic_id' => $topicId,
            'user_id' => $userId,
            'vote_time' => NOW,
        ));

        //更新票数和评分
        TopicModel::getInstance()->updateTopic($topicId, array(
            'up_count' => $topic['up_count'],
            'hot_score' => static::getHotScore($topic['create_time'], $topic['up_count']),
        ));

        //被投票的用户加分
        UserAccountService::updateScore($topic['user_id'], 'vote');
        //被投票的网站加分
        if ($topic['site_id'] > 0) {
            SiteService::updateScore($topic['site_id'], 'vote');
        }

        return $topic['up_count'];
    }

    private static function getDomain($url)
    {
        if (empty($url)) return '';
        $urlInfo = parse_url($url);
        return $urlInfo['host'];
    }

}
