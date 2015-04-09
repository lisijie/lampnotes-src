# lampnotes-src

www.lampnotes.com 网站源码

目录说明：

 - sql 数据库结构
 - app 项目源码

依赖框架：

- https://github.com/lisijie/php-framework


安装说明：

1. 下载项目和框架源代码
2. 将sql/lampnotes.sql导入数据库
3. 修改src/app/Config/dev/app.php、src/app/Config/pro/app.php 的数据库配置信息
4. 编辑src/public/index.php，修改框架路径。
4. nginx增加server，root指向到src/public目录下


nginx配置示例：

    server {
        listen       80;
        server_name  www.lampnotes.com;
        root /data/htdocs/lampnotes-src/src/public;
        index  index.html index.htm index.php;
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }

        location / {
            try_files $uri $uri/ /index.php?$args;
        }

        location ~ \.php$ {
            fastcgi_pass   unix:/tmp/php-fpm.sock;
            fastcgi_index  index.php;
            include        fastcgi.conf;
        }
        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
            expires      30d;
        }

        location ~ .*\.(js|css)?$ {
            expires      1h;
        }
    }

