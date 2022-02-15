
FROM centos:centos7
MAINTAINER xuwenjie<1054999089@qq.com>
USER root
ENV TZ=Asia/Shanghai
ENV DEBUG=false
ENV APP_ROOT=/usr/share/nginx/html
ENV MYPATH /usr/local/
WORKDIR $MYPATH
EXPOSE 8080
#-----------------------------------------------------------

# a) Install php
## 1) install yum repolist
RUN yum install -y epel-release

## 2) update yum repo
## RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

## 3) install php
RUN yum -y install php72w php72w-cli php72w-fpm
## 4) install php-extensions
RUN yum install -y php72w-common php72w-devel php72w-embedded php72w-gd php72w-mbstring php72w-mysqlnd php72w-opcache php72w-pdo php72w-xml
#-----------------------------------------------------------

# b) Install dev softwares
RUN yum install -y net-tools wget vim git nginx
RUN yum install -y software-properties-common openssl build-essential gcc g++ \
	autoconf libiconv-hook-dev libmcrypt-dev libxml2-dev libmysqlclient-dev \
	libcurl4-openssl-dev libjpeg8-dev libpng-dev libfreetype6-dev jq sudo \
	inetutils-ping net-tools rsyslog zlib1g-dev netcat-traditional lftp

# c) Copy some files
COPY build/auto_start.sh /root/auto_start.sh
COPY build/php/php.ini /etc/php.ini
COPY build/nginx/nginx.conf /etc/nginx/nginx.conf

USER root
RUN chmod u+x /root/auto_start.sh

# e) Start after todo
ENTRYPOINT /root/auto_start.sh && /bin/bash
