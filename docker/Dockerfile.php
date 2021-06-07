# 설치 할 PHP 버전
FROM php:8.0.5-fpm-alpine

# RUN docker-php-ext-install 다음에 설치하고자 하는 모듈 입력
RUN docker-php-ext-install mysqli