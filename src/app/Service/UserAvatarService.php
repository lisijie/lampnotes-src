<?php

namespace App\Service;

use \App;
use Core\Lib\File;

class UserAvatarService extends ServiceBase
{
    /**
     * 获取用户头像地址
     *
     * @param int $userId
     * @param string $size
     * @return string
     */
    public static function getUserAvatarUrl($userId, $size = 'normal')
    {
        $src = "/avatar/" . self::getHashPath($userId, $size);
        return $src;
    }

    public static function getHashPath($userId, $size = 'normal')
    {
        $hash = md5(AUTH_KEY . $userId);
        return substr($hash, -8, 4) . '/' . substr($hash, -4, 4) . '/' . $userId . '_' . $size . '.png';
    }

    /**
     * 上传头像
     *
     * @param int $userId
     * @return array
     */
    public static function uploadAvatar($userId)
    {
        $config = App::conf('upload', 'avatar');
        $result = array();
        foreach (array('__avatar1' => 'large', '__avatar2' => 'normal', '__avatar3' => 'small') as $field => $size) {
            if (isset($_FILES[$field])) {
                if (is_uploaded_file($_FILES[$field]['tmp_name'])) {
                    if ($_FILES[$field]['size'] > $config['maxsize'] * 1024) {
                        continue;
                    }
                    $info = getimagesize($_FILES[$field]['tmp_name']);
                    if (isset($info['mime']) && in_array($info['mime'], array('image/png', 'image/jpeg', 'image/gif'))) {
                        $saveName = $config['save_path'] . self::getHashPath($userId, $size);
                        File::makeDir(dirname($saveName));
                        if (move_uploaded_file($_FILES[$field]['tmp_name'], $saveName)) {
                            $result[] = self::getUserAvatarUrl($userId, $size);
                        }
                    }
                }
            }
        }
        return $result;
    }
}