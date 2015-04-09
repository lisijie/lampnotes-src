<?php
namespace App\Service;

use \App;
use App\Exception\ServiceException;

class SettingService extends ServiceBase
{
    public static function get($key)
    {
        $setting = App::conf('setting');

        if (strpos($key, '.') > 0) {
            list($group, $name) = explode('.', $key, 2);
            if (!isset($setting[$group][$name])) {
                throw new ServiceException('设置项不存在:' . $key);
            }
            return $setting[$group][$name];
        }

        if (!isset($setting[$key])) {
            throw new ServiceException('设置项不存在:' . $key);
        }
        return $setting[$key];
    }

}