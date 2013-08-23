# unfortunatly makefiles use tabs instead of white spaces , so beware !

github:

	git add .
	git commit -am"update"
	git push origin master

deploy:

	git add .
	git commit -am"deploy"
	git push heroku master

.PHONY: github