FROM alpine:latest

MAINTAINER AlicFeng <a@samego.com>

COPY app.k8s.com /www
COPY nginx/default.conf /etc/nginx/conf.d/
COPY supervisor/supervisor.ini /etc/supervisor.d/
COPY start.sh /

RUN \
# use aliyun mirrors && update
sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
&& apk update \
# install php
&& apk add php7 \
    php7-fpm \
    php7-json \
    # install nginx
    nginx \
    # install supervisor
    supervisor \
&& mkdir -p /etc/supervisor.d/ \
&& mkdir /run/nginx \
&& touch /run/nginx/nginx.pid \
&& sed -i "s/nobody/nginx/g" /etc/php7/php-fpm.d/www.conf \
&& chmod -R a+w /www \
&& chmod -R a+w /var/log \
&& rm -rf /tmp/* /var/cache/apk/*

CMD ["/start.sh"]
