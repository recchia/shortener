# Shortener
Application for generate short url version from long urls, developed with Symfony 5.3, Stimulus, React & Bootstrap. MYSQL as Database and RabbitMQ as Queue service.

###Requirements:

* Docker
* Docker Compose

###Steps for setup

***1 - Get the project:***
```{bash}
git clone git@github.com:recchia/shortener.git
cd shortener
```

***2 - Rename the follow files and complete environment variables:***

docker/mysql/database.env.dist as docker/mysql/database.env
```{bash}
MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=database
MYSQL_USER=user
MYSQL_PASSWORD=password
```

docker/rabbitmq/queue.env.dist as docker/rabbitmq/queue.env
```{bash}
RABBITMQ_ERLANG_COOKIE=cookie12345
RABBITMQ_DEFAULT_USER=rabbitmq
RABBITMQ_DEFAULT_PASS=rabbitmq
RABBITMQ_DEFAULT_VHOST=/
```

***3 - Start containers:***
```{bash}
docker-compose up -d
```

***4 - Install vendors:***
```{bash}
docker-compose exec php composer install
```

***5 - Install and compile assets:***
```{bash}
docker-compose exec php yarn install
docker-compose exec php yarn dev
```

***6 - Execute Migrations:***
```{bash}
 docker-compose exec php bin/console d:m:m
```

***7 - Execute worker:***
```{bash}
docker-compose exec php bin/console messenger:consume async
```

***8 - Load in browser:***

* http://localhost for app

* http://localhost/admin for dashboard

* http://localhost/api for swagger UI

###Run Test Suite
```{bash}
docker-compose exec php vendor/bin/phpunit --testdox
```