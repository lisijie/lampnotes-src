<?php

namespace App\Controller\User;

use App\Controller\Base;
use App\Service\UserAccountService;
use App\Service\UserProfileService;


class ViewController extends Base
{

    public function indexAction()
    {
        $userName = $this->get('id');

        if (empty($userName)) {
            \App::abort(404);
        }

        $account = UserAccountService::getUserInfoByUserName($userName);

        if (empty($account)) {
            \App::abort(404);
        }

        $profile = UserProfileService::getUserProfile($account['id']);

        $this->setHeaderMetas($userName . '的个人信息');
        $profile['user_name'] = $account['user_name'];
        $profile['nick_name'] = $account['nick_name'];
        $profile['reg_time'] = $account['reg_time'];
        $this->assign('profile', $profile);
        $this->display();
    }

}
