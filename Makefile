##
## LetShout API
##
## @author	Fernando Pradas, <fnando08@gmail.com>
##
## @description	Makefile to build and start let-shout API project
##
## Avaliable commands are:
##

all: help

ROOT_DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
RUNNER_IMAGE=fnando08/lshout:php71-runner

.PHONY : help
## help:			shows this help
help : Makefile
	@sed -n 's/^##//p' $<

.PHONY: start
## start:			stats the project
start:
	docker-compose up -d

.PHONY: stop
## stops:			stops the project
stop:
	docker-compose stop

.PHONY: restart
## restart:		restarts the project
restart: stop start

.PHONY: destroy
## destroy:		destroys the project
destroy:
	docker-compose down -v

.PHONY: logs
## logs:			shows the logs
logs:
	docker-compose logs -f

.PHONY: status
## status:		shows the containers status
status:
	docker-compose ps

.PHONY: build-runner
## build-docker:		builds docker runner image
build-runner:
	docker build -t ${RUNNER_IMAGE} docker/runner

.PHONY: configure
## configure:		run necessary task to build the project
configure:
	@-cp -n .env.dist .env

.PHONY: build
## build:			builds the project
build: configure
	docker run --rm --env-file .env -e SYMFONY_ENV=prod -v $(ROOT_DIR):/app ${RUNNER_IMAGE} bash -c "\
		composer install; \
		chmod -R 777 var vendor \
	"

.PHONY: test
## test:			tests
test: build
	make configure
	docker run --rm -t --env-file .env -v $(ROOT_DIR):/app ${RUNNER_IMAGE} bash -c "\
		vendor/bin/phpunit --testsuite unit --testdox --coverage-text; \
	"


.PHONY: test-integration
## test-integration:	executes integration tests
test-integration: build
	docker-compose -p letshout -f docker-compose.test.yml up -d
	sleep 5
	-docker run --network letshout_test --rm -t -v $(ROOT_DIR):/app ${RUNNER_IMAGE} bash -c "\
    		vendor/bin/behat; \
    	"
	docker-compose -p letshout -f docker-compose.test.yml down

.PHONY: shell
## shell:			runs an interactive shell
shell:
	make configure
	docker run --rm -it --env-file .env -v $(ROOT_DIR):/app ${RUNNER_IMAGE} bash -l

