## criando migration
	php artisan make:model Product -m

## criando o controller com todos os metodos
	php artisan make:controller ProductController

## Bug na migrate
	Schema::defaultStringLength(191);
	https://github.com/laravel/framework/issues/17508