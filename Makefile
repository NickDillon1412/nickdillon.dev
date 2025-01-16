# Run any commands here in your terminal
# Example: make install

.SILENT:

#---------- DEVELOP ------------

# Start the dev environment
up: install docker/up db/fresh

# Stop the dev environment
down: docker/down

reset: docker/down docker/prune up

#---------- INSTALL ------------

# Install everything from scratch
install: env/copy composer/install artisan/generate-key npm/install

# Copy .env.example to env if it doesn't exist
env/copy:
	cp -n .env.example .env || true

# Set the laravel app key
artisan/generate-key:
	./bin/artisan key:generate

# Install composer dependencies
composer/install:
	./bin/composer install

# Dump composer autoloader - fixes common issues
composer/dump:
	./bin/composer dump-autoload

# Install NPM dependencies
npm/install:
	./bin/npm install

# Start docker containers
docker/up:
	docker compose up -d

# Stop docker containers & delete data
docker/down:
	docker compose down

# Force delete all containers and volumes
docker/prune:
	docker container prune --force || true
	docker volume prune --all --force || true

#----------- DATABASE --------------

# Reset the database
db/fresh:
	./bin/artisan db:wipe
	./bin/artisan migrate:fresh --seed

#------------ BUILD --------------

# Build frontend assets
npm/build:
	./bin/npm run build

#------------- TEST --------------

# Run Pest tests
test:
	./bin/artisan test

test/coverage:
	docker compose run --rm web sh -c "php artisan test --colors=always --coverage-html=coverage"

#Run a specific test - ran like: make test/specific arg=SomeTest
test/specific:
	./bin/artisan test --filter $(arg)

test/portfolio:
	./bin/artisan test --filter=Portfolio

test/movie:
	./bin/artisan test --filter=Movie

test/pure-finance:
	./bin/artisan test --filter=PureFinance

# Format the code
format:
	./vendor/bin/pint

#------------- Queues/Scheduling --------------
schedule-run:
	./bin/artisan schedule:run

schedule-work:
	./bin/artisan schedule:work

queue-work:
	./bin/artisan queue:work

queue-restart:
	./bin/artisan queue:restart

cache-clear:
	./bin/artisan cache:clear

config-clear:
	./bin/artisan config:clear
