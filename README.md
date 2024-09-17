# roanimob - Backend com Laravel e PostgreSQL

Este projeto é o backend do sistema **roanimob**, desenvolvido com **PHP** e o framework **Laravel**, utilizando **PostgreSQL** como banco de dados.

## Configurações Iniciais

### 1. Instalação do PHP 8.3

1. Adicione o repositório `ondrej/php`:
   ```bash
   sudo add-apt-repository ppa:ondrej/php
   sudo apt update```

2. Instale o PHP 8.3:
    ```bash
sudo apt install php8.3 php8.3-fpm php8.3-cli```

Configure o Apache para usar PHP 8.3 com FastCGI:

bash

sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php8.3-fpm
sudo systemctl restart apache2

Verifique a versão do PHP ativa no Apache:

bash

    php -v

2. Remover Versões Antigas do PHP

Para remover a versão PHP 7.2 sem afetar outras versões:

bash

sudo apt purge php7.2*
sudo apt autoremove
sudo apt autoclean

3. Configuração do Virtual Host

No arquivo de configuração do Apache (ex: /etc/apache2/sites-available/roanimob.conf), configure o DocumentRoot para apontar para o diretório public do Laravel:

apache

<VirtualHost *:80>
    ServerName roanimob.local
    DocumentRoot /var/www/html/roanimob/public

    <Directory /var/www/html/roanimob/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/roanimob-error.log
    CustomLog ${APACHE_LOG_DIR}/roanimob-access.log combined
</VirtualHost>

Reinicie o Apache para aplicar as configurações:

bash

sudo systemctl restart apache2

4. Instalar e Configurar o Laravel

    Instale o Composer (se ainda não estiver instalado):

    bash

sudo apt update
sudo apt install curl php-cli php-mbstring git unzip
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

Navegue até a pasta do projeto e instale o Laravel:

bash

cd /var/www/html/roanimob
composer create-project --prefer-dist laravel/laravel .

Configure as permissões necessárias:

bash

sudo chown -R www-data:www-data /var/www/html/roanimob
sudo chmod -R 775 /var/www/html/roanimob/storage
sudo chmod -R 775 /var/www/html/roanimob/bootstrap/cache

Configure o ambiente Laravel:

bash

    cp .env.example .env
    php artisan key:generate

5. Configuração do Banco de Dados PostgreSQL

    Instale o driver PostgreSQL para PHP:

    bash

sudo apt install php8.3-pgsql

Configure o banco de dados no arquivo .env do Laravel:

env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

Crie o banco de dados no PostgreSQL:

bash

sudo -u postgres psql

No prompt do PostgreSQL, execute:

sql

CREATE DATABASE nome_do_seu_banco;
CREATE USER seu_usuario WITH PASSWORD 'sua_senha';
GRANT ALL PRIVILEGES ON DATABASE nome_do_seu_banco TO seu_usuario;
\q

Teste a conexão e aplique as migrações do Laravel:

bash

    php artisan migrate

6. Sincronização com o GitHub

    Inicialize o repositório Git e adicione o remoto:

    bash

    cd /var/www/html/roanimob
    git init
    git add .
    git commit -m "Initial commit"
    git remote add origin https://github.com/gaabriel000/roanimob.git
    git push -u origin master

Este README documenta o processo de configuração do ambiente de desenvolvimento para o projeto roanimob.
