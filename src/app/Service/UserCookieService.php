<?php

namespace App\Service;

use \App;
use \Core\Cipher;

class UserCookieService extends ServiceBase
{
    //登录Cookie名称
    const COOKIE_NAME = '_auth_';
    //登录Cookie加密密钥
    const COOKIE_ENCRYPT_KEY = 'as$?*A]jz0=l1DA';

    /**
     * 写入登录Cookie
     *
     * @param array $userInfo
     * @param int $expire
     * @return bool
     */
    public static function setLoginCookie(array $userInfo, $expire = 0)
    {
        if (empty($userInfo)) {
            return false;
        }
        $cookie = array(
            'user_id' => $userInfo['id'],
            'user_name' => $userInfo['user_name'],
        );
        $cookie = Cipher::encrypt(json_encode($cookie), self::getCookieEncryptKey());
        App::getResponse()->setCookie(self::COOKIE_NAME, array(
            'value' => $cookie,
            'expire' => $expire > 0 ? time() + $expire : 0,
            'httponly' => true,
            'path' => '/',
        ));
    }

    /**
     * 返回当前登录用户的Cookie信息
     *
     * @return array Cookie信息
     */
    public static function getLoginInfo()
    {
        $request = App::getRequest();
        $cookie = $request->getCookie(self::COOKIE_NAME);
        if ($cookie) {
            $value = Cipher::decrypt($cookie, self::getCookieEncryptKey());
            if (!empty($value)) {
                $value = json_decode($value, true);
                if (is_array($value)) {
                    return $value;
                }
            }
            self::clearCookie();
        }
        return array();
    }

    /**
     * 获取登录的用户ID
     *
     * @return int
     */
    public static function getLoginUserId()
    {
        $info = self::getLoginInfo();
        return isset($info['user_id']) ? intval($info['user_id']) : 0;
    }

    /**
     * 获取登录的用户名
     *
     * @return string
     */
    public static function getLoginUserName()
    {
        $info = self::getLoginInfo();
        return isset($info['user_name']) ? $info['user_name'] : '';
    }

    /**
     * 清除登录Cookie
     */
    public static function clearCookie()
    {
        App::getResponse()->removeCookie(self::COOKIE_NAME);
    }

    /**
     * 返回Cookie的加密密钥
     * @return string
     */
    private static function getCookieEncryptKey()
    {
        return self::COOKIE_ENCRYPT_KEY . App::getRequest()->getClientIp();
    }
}