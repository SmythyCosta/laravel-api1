## criando model c/ migration
	php artisan make:model Product -m

## criando o controller c/ todos os metodos
	php artisan make:controller ProductController -r

## Bug na migrate
	Schema::defaultStringLength(191);
	https://github.com/laravel/framework/issues/17508



## End-Point
	http://localhost:8000/api/v1/products

## crud finalizado