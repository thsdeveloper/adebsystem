FROM dockerimages.mctic.gov.br/publico/imagens/centos7-php72-apache:latest

ENV CONFIG_ENVIRONMENT=dsv

# Adicionar as excessões no arquivo .gitignore para não copiar o diretório .git, por exemplo
COPY --chown=apache:apache . /var/www/html/
#COPY .docker/vhost.conf /etc/httpd/conf.d/000-default.conf
COPY .docker/htaccess /var/www/html/public/.htaccess

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/httpd/conf/httpd.conf && \
    sed -i '151s|None|All|' /etc/httpd/conf/httpd.conf && \
    sed -i "s|upload_max_filesize = 2M|upload_max_filesize = 50M|g" /etc/php.ini && \
    sed -i "s|post_max_size = 8M|post_max_size = 50M|g" /etc/php.ini && \
    ln -s /var/www/html/storage/app/blobs /var/www/html/public
