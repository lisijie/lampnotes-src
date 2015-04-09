<?php
namespace App\Service;

use \App;
use App\Model\SiteModel;

class SiteService extends ServiceBase
{

    public static function getTopList($num)
    {
        $list = SiteModel::getInstance()->getListByScore($num);

        return $list;
    }

    public static function addTopicCount($siteId, $value)
    {
        return SiteModel::getInstance()->incrementField($siteId, 'topic_count', $value);
    }

    public static function updateScore($siteId, $type)
    {
        $config = App::conf('setting', 'score');
        $config = $config['site'];
        if (!isset($config[$type])) {
            throw new \InvalidArgumentException('类型无效: ' . $type);
        }
        return SiteModel::getInstance()->incrementField($siteId, 'score', intval($config[$type]));
    }
}