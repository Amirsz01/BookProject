FROM nginx

WORKDIR /var/www

RUN chown -R root:root /var/www && chmod -R 777 /var/www
RUN touch /var/run/nginx.pid && \
        chown -R root:root /var/run/nginx.pid
RUN rm -fr /var/www/var/cache/*
EXPOSE 80
