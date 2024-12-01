.PHONY: run install migrate all

run:
	./vendor/bin/sail up -d --build --force-recreate

install:
	./vendor/bin/sail composer install

migrate:
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail artisan db:seed --class CommentSeeder

all: run install migrate
