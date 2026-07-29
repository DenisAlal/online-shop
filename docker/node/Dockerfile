FROM node:22

RUN apt-get update && apt-get install -y \
    ca-certificates \
    curl \
    unzip \
    lsb-release \
    apt-transport-https \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sSL https://packages.sury.org/php/apt.gpg \
    -o /usr/share/keyrings/sury-php.gpg

RUN echo "deb [signed-by=/usr/share/keyrings/sury-php.gpg] https://packages.sury.org/php/ bookworm main" \
    > /etc/apt/sources.list.d/php.list

RUN apt-get update && apt-get install -y \
    php8.4-cli \
    php8.4-mbstring \
    php8.4-pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN php -v
