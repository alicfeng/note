**Nginx防盗链**
~~~conf
location ~* ^.+\.(gif|jpg|png|rar|zip|doc|pdf|gz|bz2|jpeg|bmp|xls|mp4|mp3)$
{
    expires 7d;
    valid_referers none blocked server_names  *.samego.com ; #只允许samego.com域
    if ($invalid_referer) {
        return 403;
    }
    access_log off;
}
~~~
