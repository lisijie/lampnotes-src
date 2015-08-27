<?php

namespace App\Controller\User;

use App\Controller\Base;
use App\Service\UserAccountService;
use App\Service\UserCookieService;

class AccountController extends Base
{
    //用户注册
    public function registerAction()
    {
        if ($this->isSubmit()) {
            try {
                $userName = $this->get('username');
                $password = $this->get('password');
                $password2 = $this->get('password2');
                $email = $this->get('email');

                $data = array('userName' => $userName, 'email' => $email);
                if (empty($userName) || empty($password) || empty($password2) || empty($email)) {
                    $data['errMsg'] = '请输入完整信息';
                    return $this->flashMessage($data);
                }
                if ($password != $password2) {
                    $data['errMsg'] = '两次输入的密码不一致';
                    return $this->flashMessage($data);
                }

                UserAccountService::register($userName, $password, $email);
                UserAccountService::login($userName, $password);
                return $this->redirect('/');
            } catch (\Exception $e) {
                return $this->flashMessage(array('errMsg' => $e->getMessage(), 'userName' => $userName, 'email' => $email));
            }
        }

        $this->setHeaderMetas(0, '注册');

        $this->assign(array(
            'errMsg' => $this->session->getFlash('errMsg'),
            'userName' => $this->session->getFlash('userName'),
            'email' => $this->session->getFlash('email'),
        ));

        $this->display();
    }

    //用户登录
    public function loginAction()
    {
        $refer = $this->get('refer');

        if ($this->userId > 0) {
            return $this->redirect('/');
        }

        if ($this->isSubmit()) {
            try {
                $account = $this->get('account');
                $password = $this->get('password');
                $remember = $this->get('remember');

                $expire = $remember ? 86400 * 7 : 0;

                UserAccountService::login($account, $password, $expire);
                return $this->redirect($refer ? $refer : '/');
            } catch (\Exception $e) {
                return $this->flashMessage(array('errMsg' => $e->getMessage()));
            }
        }

        $this->setHeaderMetas(0, '登录');
        $this->assign('refer', $refer ? : $this->getRefer());
        $this->assign('errMsg', $this->session->getFlash('errMsg'));
        $this->display();
    }

    //退出登录
    public function logoutAction()
    {
        UserCookieService::clearCookie();
        $this->redirect($this->getRefer());
    }
}