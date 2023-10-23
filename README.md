# YasbiSaEAB

**YasbiSaEAB** is an unnecessarily complex acronym for
Yet another simple blog in Symfony and Easy Admin Bundle.

## Requirements

 * docker
 * docker-compose
 * bash (for init op script)

## Installation

```
./op up
./op exec app bash

composer install
yarn install
yarn build

## create new datebase
./bin/console d:d:c

## create schema
./bin/console d:s:c

## insert first admin user
./bin/console d:q:s "INSERT INTO user (name, email, roles, password) VALUES ('admin', 'admin@localhost', '[\"ROLE_ADMIN\"]', '\$2y\$13\$7nS91JSBzPlJOslhg05Ce.NIHWtlvdJuDHt73Hh2KgLBYykJb1f96');"
```

### Default credentials (for login)

```
email           ;; pass
admin@localhost ;; admin
```

## Architecture

Standard nginx web server with php-fpm and MySQL database.
In app (php-fpm) container is installed node with yarn
(only for simplify development - No brain, no pain).
Adminer as simple database tool. And mailpit as mail catcher.

## TODOs

 * [ ] discussion in threads (ready to implement - see BlogPostComment->getParent())
 * [ ] discussion redaction (ready to implement - see BlogPostComment->getRedacted*() and part of admin UI)
 * [ ] prefill email address in comment form for logged users
