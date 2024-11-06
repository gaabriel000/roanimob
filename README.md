# Roanimob - Sistema de controle de alugueis

**Roanimob** é um sistema de código aberto e gratuito projetado para o controle de aluguéis. Destinado a pequenos negócios imobiliários, corretores independentes, síndicos e proprietários individuais, o sistema oferece uma solução prática e acessível para gerenciar propriedades e aluguéis.

## Características

- **Interface Simples e Intuitiva**: Desenvolvido com uma interface amigável para facilitar o uso por qualquer pessoa, sem necessidade de treinamento avançado.
- **Modelo Web**: Acesso ao sistema via navegador, permitindo gerenciamento de qualquer lugar com conexão à internet.
- **Código Aberto**: Totalmente livre para uso e modificação, sem restrições de licença. Sinta-se à vontade para adaptar o sistema às suas necessidades.

## Configuração

Para auxiliar na configuração o Roanimob, há duas seções abaixo con instruções específicas:

1. **Configuração para Uso Final**: Configure o sistema para o uso diário, conectando-o a bancos de dados e ajustando as configurações conforme necessário.
2. **Montagem do Ambiente de Desenvolvimento**: Prepare seu ambiente para desenvolvimento do sistema, incluindo a instalação de dependências e configuração do servidor (apenas para desenvolvedores).

## Suporte

Se precisar de assistência adicional, entre em contato pelo e-mail: [gabrielroani2@gmail.com](mailto:gabrielroani2@gmail.com). Para questões individuais, evite usar o GitHub Issues ou mensagens diretas (não sou um usuário muito ativo aqui). Estou aqui para ajudar!

## 2. Montagem do Ambiente de Desenvolvimento

### Instalação do PHP 8.3

1. Adicione o repositório `ondrej/php`:
   ```bash
   sudo add-apt-repository ppa:ondrej/php
   sudo apt update

2. Instale o PHP 8.3:
    ```bash
    sudo apt install php8.3 php8.3-fpm php8.3-cli

3. Configure o Apache para usar PHP 8.3 com FastCGI:
    ```bash
    sudo a2enmod proxy_fcgi setenvif
    sudo a2enconf php8.3-fpm
    sudo systemctl restart apache2

4. Verifique a versão do PHP ativa no Apache:
    ```bash
    php -v

5. Configuração do Virtual Host com Laravel no arquivo /etc/apache2/sites-available/roanimob.conf. Lembre-se de alterar a porta 80 caso você opte por uma porta personalizada.
    ```bash
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

6. Caso opte por uma porta personalizada, adicione a linha no arquivo /etc/apache2/ports.conf para o apache redirecionar para essa porta.
    ```bash
    Listen 80XX

7. Reinicie o Apache para aplicar as configurações:
    ```bash
    sudo systemctl restart apache2
    
### Instalação do Laravel com PHP 8.3

1. Instalar e Configurar o Composer
    ```bash
    sudo apt update
    sudo apt install curl php-cli php-mbstring git unzip
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer

2. Configure o ambiente Laravel:
    ```bash
    cp .env.example .env
    php artisan key:generate

### Configuração do Banco de Dados PostgreSQL

1. Instale o driver PostgreSQL para PHP:

    ```bash
    sudo apt install php8.3-pgsql

2. Configure o banco de dados no arquivo .env do Laravel:
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=roanimob
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha

3. Crie o banco de dados local no PostgreSQL:
    ```bash
    sudo -u postgres psql

4. No prompt do PostgreSQL, execute:
    ```sql
    CREATE DATABASE roanimob;
    CREATE USER seu_usuario WITH PASSWORD 'sua_senha';
    GRANT ALL PRIVILEGES ON DATABASE nome_do_seu_banco TO seu_usuario;
    \q

5. Teste a conexão e aplique as migrações do Laravel:
    ```bash
    php artisan migrate
