<?php


return array(

    'site' => array(
        'title' => 'Web开发技术分享平台',
        'name' => 'LAMP Notes',
        'url' => 'http://www.lampnotes.com',
        'beian' => '',
        'statcode' => '',
        'keywords' => 'Web开发,程序员,Linux,Apache,Nginx,MySQL,PHP,LAMP,LNMP',
        'description' => 'LAMP Notes是一个Web开发技术的分享平台，我们希望为广大Web开发人员提供纯粹、高质的内容。任何人都可以在这里注册并投递文章、参与讨论、给文章投票，优秀的内容将会出现在首页。',
    ),

    //积分设置
    'score' => array(
        'user' => array(
            'add_topic' => 0, //投稿
            'del_topic' => -5, //内容被删
            'vote' => 1, //内容被顶
        ),
        'site' => array(
            'add_topic' => 0, //投稿
            'del_topic' => -5, //内容被删
            'vote' => 1, //内容被顶
        ),
    ),
);