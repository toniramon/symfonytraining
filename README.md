
# symfonytraining
Symfony API Rest training


- Key factors:
    - Added docker container.
        - docker-compose up -d (create 3 containers)
        - Need to map: [dev.symfonytraining.com](http://dev.symfonytraining.com) to [localhost](http://localhost) on /etc/hosts
    - Added DB dump for structure and data.
    - PSR-12 Standard && PHPStan
    - TDD for API Rest Endpoints
    - Delegate responsability, each entity do it's job.
    - Patterns used: Repository Pattern, Active Record (Mapping models to DTO), Decorator pattern for annotations., Dependency injection, SOLID.
    - ORM: Doctrine
    - Bundles Utilizados: FOSRestBundle, Maker Bundle
    - Uso verbos REST
    - Buenas Prácticas (Scafolding Domain based, SOLID, DRY)
    - Added Postman Collection with all endpoints
    - Composer check for psr12 and autofix.
  
Commands used

DB Related
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:diff
- php bin/console doctrine:migrations:migrate

Tests
- vendor/bin/phpunit —testdox tests/