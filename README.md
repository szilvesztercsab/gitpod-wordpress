# A Wordpress template on Gitpod

This is a Wordpress template configured for ephemeral development environments on [Gitpod](https://www.gitpod.io/).

## Usage

Click the button below to start the Gitpod development environment:

[![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://github.com/szilvesztercsab/gitpod-wordpress)

This will run and install Wordpress and expose it to the public from your Gitpod environment.
The admin interface can be accessed then with username `admin` and password `admin`.

[phpMyAdmin](https://www.phpmyadmin.net) is also spun up in private
and can be accessed using the username `root` and password `supersecretpassword`.

A [MailHog](https://github.com/mailhog/MailHog) container is also provided in private.

To make use of this repository in your own project, either fork this repository or
just copy the [`.gitpod.yml`](.gitpod.yml), [`mailhog.php`](./mailhog.php)
and [`docker-compose.yaml`](docker-compose.yaml) files to your project folder.

## Files

- [`docker-compose.yaml`](docker-compose.yaml)
  ([Docker compose file](https://docs.docker.com/compose/) that defines
  a `mysql`, `wordpress`, `phpMyAdmin`, `MailHog` and a `wp-cli` container)
- [`.gitpod.yml`](.gitpod.yml)
  ([Gitpod configuration file](https://www.gitpod.io/docs/config-gitpod-file)
  that will start and install Wordpress on docker containers)
- [`mailhog.php`](mailhog.php)
  (Tweaked [MailHog Wordpress plugin](https://wordpress.org/plugins/wp-mailhog-smtp/)
  definition for the docker environment)
- [`README.md`](README.md) (this document)

## Working with the containers

You can use `docker compose` commands to manage the containers. Check out
[the `docker compose` documentation](https://docs.docker.com/engine/reference/commandline/compose/)
for more details.

### Stop containers and remove them

```bash
docker compose down --rmi all -v
```

### Start containers

```bash
docker compose up --quiet-pull -d
```

### Install wordpress from the command line

```bash
docker compose exec wp-cli /bin/bash -c '\
  wp core install \
    --path="/var/www/html" \
    --url="'$(gp url 8000)'" \
    --title="${WORDPRESS_SITE_NAME}" \
    --admin_user="${WORDPRESS_ADMIN_USER}" \
    --admin_password="${WORDPRESS_ADMIN_PASSWORD}" \
    --admin_email="${WORDPRESS_ADMIN_EMAIL}"\
'
```

_Note: The variables used in the above command are expanded in the `wordpress-cli` container itself,
except the `gp url 8000` command which is expanded on the Gitpod host instead
(hence the closing and re-opening the single quotes)._

### Get information on the Wordpress instance

```bash
docker compose exec wp-cli wp --info
```

## Working with Gitpod

The `gp` command line tool can be used to manage the Gitpod workspace from the terminal. Check out
[the `gp` command documentation](https://www.gitpod.io/docs/command-line-interface#command-line-interface)
for more details.

### Get the public url of the Wordpress instance

```bash
gp url 8000
```

### Stop the Gitpod workspace

This is useful as the Gitpod Free plan only allows you 50 hours of work a month.

```bash
gp stop
```
