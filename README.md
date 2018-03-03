# Contacts

POC using Symfony project.

## Configuration

* Enable `php_fileinfo` extension in your `php.ini`.
* Setup your Database connector in `app/config/config.yml`
* Execute `composer intall`
* Generate the SSH keys :

```bash
mkdir -p var/jwt # For Symfony3+, no need of the -p option
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

* Create Database `php bin/console doctrine:database:create`
* Create Tables `php bin/console doctrine:schema:update --force`
* Load DataFixtures if needed : `php bin/console doctrine:fixtures:load`
* Launch server : `php bin/console server:run`

## Tests

Just write your tests and run `./vendor/bin/simple-phpunit`. It is a wrapper provided
by Symfony.

## Authors

* Yoann Fleury <yoann.fleury@docapost-agility.fr>
* Georges Buquet <georges.buquet@docapost-agility.fr>

