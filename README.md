# Contacts

POC using Symfony project.

## Config

1. Setup your Database connector in `app/config/config.yml`
2. Execute `composer intall`
3. Create Database `php bin/console doctrine:database:create`
4. Create Tables `php bin/console doctrine:schema:update --force`
3. Load DataFixtures if needed : `php bin/console doctrine:fixtures:load`
4. Launch server : `php bin/console server:run`


## Author

* Yoann Fleury <yoann.fleury@docapost-agility.com>
