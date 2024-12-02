# CMS

CMS system with posts and comments.

# Installation
You need to have [Docker](https://www.docker.com/) installed on your machine.

1. Clone the repository
2. For unix systems with Make, you can simply run `make all` and the project will be up and running.
3. For not unix systems, you can run the following commands:
    - ./vendor/bin/sail up -d --build --force-recreate
    - ./vendor/bin/sail composer install
    - ./vendor/bin/sail artisan migrate
    - ./vendor/bin/sail artisan db:seed --class CommentSeeder
4. The project will be available at http://localhost and all the endpoints will be available at http://localhost/api
