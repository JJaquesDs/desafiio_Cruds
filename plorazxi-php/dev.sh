# Variáveis:
APP_IMAGE_NAME="app-php-dev:dev-0.1"
APP_NETWORK_NAME="app-php-network"

# Buildando o projeto
docker build -t $APP_IMAGE_NAME .

# Criando a network
docker network create $APP_NETWORK_NAME

# Correndo os containers a partir das imagens, cada uma configurada do jeito necessário
docker run -d \
    -p 8080:8080 \
    -v /usr/local/app/vendor \
    -v .:/usr/local/app \
    --network $APP_NETWORK_NAME \
    --name app-php-cont \
    $APP_IMAGE_NAME

docker run -d \
    -p 3306:3306 \
    -e MYSQL_ROOT_PASSWORD="0000" \
    -e MYSQL_DATABASE="php_api_dev" \
    -e MYSQL_USER="root" \
    -e MYSQL_PASSWORD="0000" \
    --network $APP_NETWORK_NAME \
    --name mysql-cont \
    mysql/mysql-server:latest