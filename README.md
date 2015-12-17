# ISIMA ZZ2  - Project
# Vincent Mizoules - Alexandre Barret

# Commands

Install dependencies

	cd website
    docker run -v $(pwd):/app composer/composer install

Launch all container

	cd docker
	dc rm -f && dc build && dc up
