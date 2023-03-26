<h1 align="center"><a href="#">Magentify Store</a></h1>

## Prerequisites

-   [Git](https://git-scm.com/downloads)
-   [Composer v2](https://getcomposer.org/download/)
-   [Symfony Cli](https://symfony.com/download)
-   [Yarn](https://yarnpkg.com/cli/install)
-   Node 18, you can use [NVM](https://github.com/nvm-sh/nvm)
-   PHP 8.2

## Installation

```bash
git clone git@github.com:lamasfoker/magentify-store.git
cd magentify-store
composer install
yarn install
yarn build
```

Check the `.env` file and the `docker-compose.yml` file. If you have to change something, do it on the override file `.env.local` and `docker-compose.override.yml` respectively.

Build the docker images and start the containers:

```bash
docker-compose up -d
```
If you use Symfony CLI local webserver start it:

```bash
symfony serve -d
```

You can now browse the project with your browser the host and port configured in your local webserver. For example if you use Symfony CLI with TLS enabled:

```bash
open https://127.0.0.1:8000
```

## Coding style and standards

In the project there are a few tools to enforce a proper coding style.

First of all, you can check the coding standards with

```bash
vendor/bin/ecs check
```

and you can fix automatically the "fixable" errors with

```bash
vendor/bin/ecs check --fix
```

There are two tools to perform static analysis checks:

```bash
vendor/bin/phpstan analyse
vendor/bin/psalm
```

## Using GIT hooks with CaptainHook

This project provides a [CaptainHook](https://github.com/captainhookphp/captainhook) configuration file (see `captainhook.json`).
If you want to install the configured GIT hooks you have to run:

```bash
vendor/bin/captainhook install
```

## Troubleshooting

If something goes wrong, errors & exceptions are logged at the application level:

```bash
tail -f var/log/dev.log
```
