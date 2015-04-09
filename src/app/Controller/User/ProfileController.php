<?php

namespace App\Controller\User;

use App\Controller\Base;
use App\Exception\ServiceException;
use App\Service\UserAccountService;
use App\Service\UserProfileService;

class ProfileController extends Base
{
    public function init()
    {
        parent::init();
        $this->checkLogin();
    }

    /**
     * 修改个人资料
     */
    public function indexAction()
    {
        $errMsg = '';
        $sucMsg = '';
        if ($this->isSubmit()) {
            try {
                $data = array(
                    'gender' => intval($this->get('gender')),
                    'birthday' => $this->get('birthday'),
                    'headline' => $this->get('headline'),
                    'qq' => $this->get('qq'),
                    'wechat' => $this->get('wechat'),
                    'weibo' => $this->get('weibo'),
                    'city_name' => $this->get('city'),
                    'address' => $this->get('address'),
                    'homepage' => $this->get('homepage'),
                    'resume' => $this->get('resume'),
                );
                UserProfileService::updateUserProfile($this->userId, $data);
                $sucMsg = '个人资料修改成功！';
            } catch (ServiceException $e) {
                $errMsg = $e->getMessage();
            }
        }

        $this->setHeaderMetas(array('资料修改', $this->userName));
        $profile = UserProfileService::getUserProfile($this->userId);
        $this->assign(array(
            'errMsg' => $errMsg,
            'sucMsg' => $sucMsg,
            'profile' => $profile,
        ));
        $this->display();
    }

    /**
     * 修改密码
     */
    public function passwordAction()
    {
        $sucMsg = '';
        if ($this->isSubmit()) {
            try {
                $password = $this->get('password');
                $newPassword = $this->get('newpassword');
                $newPassword2 = $this->get('newpassword2');
                if (empty($password)) {
                    $this->flashMessage(array('errMsg' => '请输入当前密码'));
                }
                if (empty($newPassword)) {
                    $this->flashMessage(array('errMsg' => '请输入新密码'));
                }
                if (empty($newPassword2)) {
                    $this->flashMessage(array('errMsg' => '请输入确认密码'));
                }
                if ($newPassword != $newPassword2) {
                    $this->flashMessage(array('errMsg' => '两次输入的密码不一致'));
                }
                UserAccountService::changePassword($this->userId, $password, $newPassword);
                $sucMsg = '密码修改成功，请牢记你的新密码！';
            } catch (ServiceException $e) {
                $this->flashMessage(array('errMsg' => $e->getMessage()));
            }
        }
        $this->setHeaderMetas(array('密码修改', $this->userName));
        $this->assign(array(
            'errMsg' => $this->session->getFlash('errMsg'),
            'sucMsg' => $sucMsg,
        ));

        $this->display();
    }

}