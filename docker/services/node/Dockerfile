FROM        node:lts-alpine
LABEL       maintainer="Arnaud Ponel <arnaud@xpressive.io>"

RUN         apk add --no-cache \
            --repository http://dl-cdn.alpinelinux.org/alpine/edge/main \
            --repository  http://dl-cdn.alpinelinux.org/alpine/edge/community \
            gcc g++ make python

RUN         mkdir -p /build
COPY        ./docker/services/node /build

RUN         mkdir -p /app

VOLUME      /app
WORKDIR     /app

ENV         NODE_ENV=development

ENTRYPOINT  ["/build/entrypoint.sh"]
CMD         ["node"]
