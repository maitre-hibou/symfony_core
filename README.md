# Symfony Core

Clean design development stack for Symfony applications.

[![Build Status](https://app.travis-ci.com/maitre-hibou/symfony_core.svg?branch=master)](https://app.travis-ci.com/maitre-hibou/symfony_core)

## Installation

### Prerequisites

- Install Docker
- Install Docker Compose
- Map domain www.symfony.local to 127.0.0.1 in your `/etc/hosts` file

### Booting project

```bash
$ make install
```

### Stopping and starting

Once images are built, you can stop project by running

```bash
$ make stop
```

... and start project with

```bash
$ make up
```

## Usage with docker

A `Makefile` is present to provide shortcut to use various components inside project containers.

To check the list of all available functions, simply run

```bash
$ make
```
or
```bash
$ make help
```

Or you can check by yourself content of the `Makefile` !

### PHP tools

#### Composer

To use composer inside project use the command like

```bash
$ make composer c="update"
```

#### Symfony console

Like Composer, a shortcut is provided to use Symfony console within the command line

```bash
$ make console c="do:sc:up --dump-sql"
```

### Frontend

#### Yarn

You can run Yarn to manage your frontend dependencies with

```bash
$ make yarn c="add bootstrap"
```

#### Building assets

Run Webpack to build frontend assets with

```bash
$ make assets
```

### Testing your code

The `Makefile` also provides some shortcuts to run tests and QA analysis using PHPUnit, Psalm and PHPCS

This will executes PHPUnit and Psalm :

```bash
$ make tests
```

This will execute PHPCS

```bash
$ make quality
```

You can also run specific testing tools by using corresponding `Makefile` instruction. Simply run the `help` instruction to learn more !
