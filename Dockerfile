FROM centos:centos7
MAINTAINER xuwenjie<1054999089@qq.com>

ENV TZ=Asia/Shanghai
ENV DEBUG=false
ENV WEB_ROOT=/usr/share/nginx
EXPOSE 8080
#-----------------------------------------------------------
# a) Install Softwares
USER root
## 1) install & update yum repolist
RUN cp /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
RUN curl -o /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
# RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -ivh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm --force --nodeps
RUN yum install -y epel-release --nogpgcheck

## 2) install php
RUN yum -y install php72w php72w-cli php72w-fpm --nogpgcheck
## 3) install php-extensions
RUN yum install -y php72w-common php72w-devel php72w-embedded php72w-gd php72w-mbstring php72w-mysqlnd php72w-opcache php72w-pdo php72w-xml --nogpgcheck

## 4) Install dev softwares
RUN yum install -y net-tools wget vim git nginx --nogpgcheck
RUN yum install -y software-properties-common openssl build-essential gcc g++ \
	autoconf libiconv-hook-dev libmcrypt-dev libxml2-dev libmysqlclient-dev \
	libcurl4-openssl-dev libjpeg8-dev libpng-dev libfreetype6-dev jq sudo \
	inetutils-ping net-tools rsyslog zlib1g-dev netcat-traditional lftp --nogpgcheck

## 5) copy code & change group and mode
RUN rm -rf $WEB_ROOT/html/*
COPY . $WEB_ROOT/html 
RUN chown -R apache:apache $WEB_ROOT/html
WORKDIR $WEB_ROOT/html

## 6) Install Composer && backup ?
RUN php $WEB_ROOT/html/composer.phar install && \
	cp $WEB_ROOT/html/composer.phar /usr/local/bin/composer
	# mkdir $WEB_ROOT/composer && \
	# chown -R apache:apache $WEB_ROOT/composer  && \
	# cp -rf ./vendor $WEB_ROOT/composer && \
	# cp -rf ./composer.lock $WEB_ROOT/composer/composer.lock
#-----------------------------------------------------------
# b) Configure Env
## 1) copy config file
COPY build/auto_start.sh /root/auto_start.sh
COPY build/php/php.ini /etc/php.ini
COPY build/nginx/nginx.conf /etc/nginx/nginx.conf
## (todo) : link some bin files

# c) Start Container
RUN chmod u+x /root/auto_start.sh
ENTRYPOINT /root/auto_start.sh && /bin/bash