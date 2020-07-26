FROM ubuntu:20.04

SHELL ["/bin/bash", "-c"]

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && \
    apt-get install -y \
    php7.4 \
    php7.4-dom \
    php7.4-soap \
    php7.4-curl \
    php7.4-xdebug \
    php7.4-mbstring \
    php7.4-zip \
    curl \
    mariadb-client \
    openjdk-14-jdk \
    libreoffice \
    libreoffice-java-common

RUN mkdir /invoice-generator

ENTRYPOINT ["/bin/bash"]
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

WORKDIR /invoice-generator

EXPOSE 80
