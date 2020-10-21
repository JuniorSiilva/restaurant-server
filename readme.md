# Projeto Restaurante (Servidor)

Este projeto tem como foco aprender e evoluir conceitos voltados ao PHP/Laravel e desenvolvimento de novas técnicas de aprendizado.

Alguns dos pontos trabalhados:

  - Autenticação com sanctum
  - MongoDB para armazenamento de numeros registros
  - Implementação de sistema multi-tenancy
  - Permissões utilizando [spatie/activitylog](https://github.com/spatie/laravel-activitylog)
  - Websockets, queues, events e jobs
 
# Requisitos

- PHP 7.2^
- Extensão PHP imagick
- Extensão PHP mongodb
- Extensão PHP redis/predis


# Instalação

To install the project dependencies:
``` bash
composer install
```

Then, inside project folder:
``` bash
cp .env.example .env
```

To generate Laravel app key:
``` bash
php artisan key:generate
```

And to finish, create database structure:
``` bash
php artisan migrate:refresh --database="root" --path="database/migrations/root"

php artisan migrate:refresh --database="mongodb" --path="database/migrations/root/mongo"
```

## License

Software licensed under the [MIT license](https://opensource.org/licenses/MIT).
