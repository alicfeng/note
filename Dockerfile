FROM node:6-slim
MAINTAINER AlicFeng <a@samego.com>

ENV VERSION=3.2.3

COPY book.json /srv/gitbook/book.json
COPY book /srv/gitbook/book

RUN npm install --global gitbook-cli -ddd && \
    gitbook fetch ${VERSION} && \
    gitbook install && \
    npm cache clear


WORKDIR /srv/gitbook
VOLUME /srv/gitbook

EXPOSE 4000 35729

CMD ["gitbook","serve"]
