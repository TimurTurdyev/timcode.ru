# timcode.ru - обновление сайта на сервере.
#
#   make deploy   обычное обновление: код, зависимости, сборка, кэш
#   make          список целей
#
# Переопределяется на месте: make deploy PHP=/usr/bin/php8.3

PHP      ?= php
COMPOSER ?= composer
NPM      ?= npm
ARTISAN   = $(PHP) artisan
BRANCH   ?= main

GREEN = \033[32m
GRAY  = \033[90m
BOLD  = \033[1m
OFF   = \033[0m

.DEFAULT_GOAL := help
.PHONY: help deploy pull vendor assets migrate optimize clear cases restart test check dev

help:
	@printf "$(GREEN)timcode.ru$(OFF)\n\n"
	@printf "  $(BOLD)make deploy$(OFF)    обновить сайт целиком (обычный сценарий)\n"
	@printf "  $(BOLD)make cases$(OFF)     сбросить кэш кейсов, когда добавлен новый .md\n"
	@printf "  $(BOLD)make clear$(OFF)     сбросить все кэши приложения\n"
	@printf "  $(BOLD)make optimize$(OFF)  собрать кэш конфигов, роутов и шаблонов\n"
	@printf "  $(BOLD)make restart$(OFF)   перезапустить PHP-FPM (нужен sudo)\n"
	@printf "  $(BOLD)make check$(OFF)     проверить окружение перед первым деплоем\n"
	@printf "  $(BOLD)make test$(OFF)      прогнать тесты\n"
	@printf "\n$(GRAY)  отдельные шаги: pull, vendor, assets, migrate$(OFF)\n"

# Полный цикл обновления. Порядок важен: сначала код и зависимости,
# потом миграции, и только в конце кэш, чтобы он собрался с новых файлов.
deploy: pull vendor assets migrate optimize cases
	@printf "\n$(GREEN)Готово.$(OFF) $(GRAY)Сайт обновлён.$(OFF)\n"

pull:
	@printf "$(GRAY)>>> код$(OFF)\n"
	git pull origin $(BRANCH)

vendor:
	@printf "$(GRAY)>>> зависимости PHP$(OFF)\n"
	$(COMPOSER) install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# public/build не хранится в git, поэтому фронт собирается на сервере.
assets:
	@printf "$(GRAY)>>> сборка фронта$(OFF)\n"
	@command -v $(NPM) >/dev/null 2>&1 || { \
		printf "$(BOLD)npm не найден.$(OFF) Соберите ассеты локально и скопируйте public/build на сервер.\n"; \
		exit 1; \
	}
	$(NPM) ci --ignore-scripts || $(NPM) install --ignore-scripts
	$(NPM) run build

migrate:
	@printf "$(GRAY)>>> миграции$(OFF)\n"
	$(ARTISAN) migrate --force

optimize:
	@printf "$(GRAY)>>> кэш приложения$(OFF)\n"
	$(ARTISAN) optimize

clear:
	$(ARTISAN) optimize:clear
	$(ARTISAN) cache:clear

# Список кейсов лежит в кэше час, поэтому новый файл .md без сброса
# появится на главной не сразу.
cases:
	@printf "$(GRAY)>>> кэш кейсов$(OFF)\n"
	$(ARTISAN) cache:forget cases_list

restart:
	sudo systemctl reload php8.3-fpm || sudo systemctl reload php-fpm
	sudo systemctl reload nginx

test:
	$(ARTISAN) test

# Проверка перед первым запуском на новом сервере.
check:
	@printf "$(GRAY)php      $(OFF)"; $(PHP) -v | head -1
	@printf "$(GRAY)composer $(OFF)"; $(COMPOSER) --version 2>/dev/null | head -1 || echo "нет"
	@printf "$(GRAY)npm      $(OFF)"; $(NPM) -v 2>/dev/null || echo "нет"
	@printf "$(GRAY)env      $(OFF)"; test -f .env && grep -m1 '^APP_ENV=' .env || echo "нет .env"
	@printf "$(GRAY)база     $(OFF)"; test -f database/database.sqlite && echo "database/database.sqlite на месте" || echo "нет database/database.sqlite"
	@printf "$(GRAY)права    $(OFF)"; test -w storage && test -w bootstrap/cache && echo "storage и bootstrap/cache доступны на запись" || echo "нет прав на storage или bootstrap/cache"

dev:
	$(COMPOSER) dev
