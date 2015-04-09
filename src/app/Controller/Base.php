<?php
namespace App\Controller;

use \App;
use App\Service\UserCookieService;
use Core\Controller;
use Core\Lib\Pager;
use Core\Lib\String;
use App\Service\SettingService;

class Base extends Controller
{
    /**
     * 分页大小
     */
    const PAGE_SIZE = 30;

    /**
     * 当前登录的用户ID
     *
     * @var int
     */
    protected $userId = 0;

    /**
     * 当前登录的用户名
     *
     * @var string
     */
    protected $userName = '';

    /**
     * 当前登录的用户信息
     *
     * @var array
     */
    protected $userInfo = array();

    /**
     * session对象
     *
     * @var \Core\Session\Session;
     */
    protected $session;

    public function init()
    {
        $this->session = App::get('session');

        $this->request->addFilter('\\Core\\Lib\\String::safeStr');
        $this->view->registerFunc('time', '\\App\\Common\\Util::strTime');

        $this->view->registerFunc('pager', function ($page, $pageSize, $totalNum, $route = CUR_ROUTE, $params = array()) {
            $pager = new Pager($page, $pageSize, $totalNum, $route, $params);
            return $pager->makeHtml();
        });

        $userInfo = UserCookieService::getLoginInfo();
        if (empty($userInfo)) {
            $userInfo = array('user_id' => 0, 'user_name' => '');
        }
        $this->userId = $userInfo['user_id'];
        $this->userName = $userInfo['user_name'];
        $this->userInfo = $userInfo;
        $this->assign(array(
            'userInfo' => $userInfo,
        ));
    }

    /**
     * 设置页面头部meta变量
     *
     * @param string $title
     * @param string $keywords
     * @param string $description
     */
    protected function setHeaderMetas($title = '', $keywords = '', $description = '')
    {
        $header = array('title' => array(), 'keywords' => '', 'description' => '');
        if (!empty($title)) {
            $header['title'] = is_array($title) ? array_merge($header['title'], $title) : array($title);
        }
        if (empty($title)) {
            $header['title'][] = SettingService::get('site.title');
        }
        $header['title'][] = SettingService::get('site.name');

        if (!empty($keywords)) {
            $header['keywords'] = $keywords;
        } else {
            $header['keywords'] = SettingService::get('site.keywords');
            if (empty($header['keywords'])) {
                $header['keywords'] = $title;
            }
        }

        $header['description'] = !empty($description) ? $description : SettingService::get('site.description');
        $header['title'] = implode(' - ', $header['title']);
        foreach ($header as $key => $val) {
            $header[$key] = String::safeStr(strip_tags(str_replace(array("\r", "\n"), '', $val)));
        }

        $this->assign('header', $header);
    }

    /**
     * 是否POST请求
     *
     * @return bool
     */
    protected function isSubmit()
    {
        return $this->request->isMethod('POST');
    }

    /**
     * 登录检查
     *
     * @param bool $showMsg
     */
    protected function checkLogin($showMsg = false)
    {
        if ($this->userId < 1) {
            if ($showMsg) {
                $this->message('请先登录', MSG_LOGIN, URL('user/account/login'));
            } else {
                $this->redirect(URL('user/account/login'));
            }
        }
    }

    /**
     * 设置flash数据并跳转
     *
     * @param $data
     * @param $route
     */
    protected function flashMessage($data, $route = CUR_ROUTE)
    {
        foreach ($data as $key => $val) {
            $this->session->setFlash($key, $val);
        }
        $this->redirect(URL($route));
    }
}