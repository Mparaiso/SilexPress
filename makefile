# unfortunatly makefiles use tabs instead of white spaces , so beware !

commit:

	git add .
	git commit -am"update"
	git push origin master

deploy:

	git push heroku master -f

start:

	php -S localhost:3000 -t web web\index.php

test:

	phpunit

update:

	composer update

install:

	composer install

open:
	
	heroku open

.PHONY: commit