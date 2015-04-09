<?php

namespace App\Exception;

use Core\Exception\Handler as BaseHandler;
use Core\Exception\HttpException;
use App;

/**
 * 服务异常
 *
 * 用于Service模块抛出的异常。
 *
 * @author lisijie <lsj86@qq.com>
 * @package Core\Exception
 */
class Handler extends BaseHandler
{
    protected function renderHttpException(HttpException $e)
    {
        if ($e->getCode() == 404) {
            $view = App::get('view');
            $view->assign('site', App::conf('setting', 'site'));
            echo $view->render('errors/404');
            return;
        }

        parent::renderHttpException($e);
    }
}
