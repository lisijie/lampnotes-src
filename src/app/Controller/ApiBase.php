<?php
namespace App\Controller;

use \App;
use App\Service\UserCookieService;
use Core\Controller\ApiController as Controller;

class ApiBase extends Controller
{
    protected $userId = 0;
    protected $userName = '';

    /**
     * @var \Core\Session\Session;
     */
    protected $session;

    public function init()
    {
        $this->session = App::get('session');
        $userInfo = UserCookieService::getLoginInfo();
        if (empty($userInfo)) {
            $userInfo = array('user_id' => 0, 'user_name' => '');
        }
        $this->userId = $userInfo['user_id'];
        $this->userName = $userInfo['user_name'];
    }

    protected function isSubmit()
    {
        return $this->request->isMethod('POST');
    }

    protected function checkLogin()
    {
        if ($this->userId < 1) {
            return $this->message('请先登录', MSG_LOGIN, URL('user/account/login'));
        }
    }

}
