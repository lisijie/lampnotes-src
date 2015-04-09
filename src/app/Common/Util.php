<?php
namespace App\Common;

class Util
{

    public static function strTime($timestamp)
    {
        $diff = NOW - $timestamp;
        if ($diff < 60) {
            return $diff . '秒前';
        } elseif ($diff < 3600) {
            return floor($diff / 60).'分钟前';
        } elseif ($diff < 7200) {
            return '1小时前';
        } else {
            $ztime = strtotime(date('Y-m-d')); //零点时间戳
            if ($timestamp > $ztime) {
                return '今天 '.date('H:i',$timestamp);
            } elseif ($timestamp > ($ztime - 86400)) {
                return '昨天 '.date('H:i',$timestamp);
            } elseif (date('Y',$timestamp) == date('Y',NOW)) {
                return date('n月j日 H:i',$timestamp);
            } else {
                return date('Y年n月j日 H:i',$timestamp);
            }
        }
    }

}
