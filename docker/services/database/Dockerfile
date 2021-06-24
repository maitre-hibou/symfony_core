FROM        mysql:8.0
LABEL       maintainer="Arnaud Ponel <arnaud@xpressive.io>"

RUN         usermod -u 1000 mysql
RUN         groupmod -g 1000 mysql

RUN         chown -R mysql:mysql /var/lib/mysql
