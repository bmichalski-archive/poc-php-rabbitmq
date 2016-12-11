FROM debian:8

RUN \
  apt-get update && \
  apt-get install -y \
    php5-cli

RUN \
  adduser --disabled-password --gecos '' r
