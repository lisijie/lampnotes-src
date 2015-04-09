<?php

return array(

    'database' => array(
        //默认数据库
        'default' => array(
            //是否开启调试，开启后会记录SQL的执行信息
            'debug' => false,
            //表前缀
            'prefix' => 't_',
            //字符集
            'charset' => 'utf8',
            //写库
            'write' => array(
                'dsn' => "mysql:host=127.0.0.1;port=3306;dbname=lampnotes;charset=utf8",
                'username' => 'root',
                'password' => '',
                'pconnect' => false,
            ),
            //读库，只允许配一个地址，如果是一主多从的话，建议使用haproxy或其他中间件做转发
            'read' => array(
                'dsn' => "mysql:host=127.0.0.1;port=3306;dbname=lampnotes;charset=utf8",
                'username' => 'root',
                'password' => '',
                'pconnect' => false,
            )
        )
    ),


    //日志配置
    'logger' => array(
        //默认日志
        'default' => array(
            //日志处理器1
            array(
                'level' => 3, //日志级别: 1-8
                'handler' => 'FileHandler', //日志处理器
                'config' => array(
                    'savepath' => DATA_PATH . 'logs/', //日志保存目录
                    'filesize' => 0, //文件分割大小
                    'filename' => '{Y}{m}{d}.log',
                ),
            )
        ),
    ),

);
