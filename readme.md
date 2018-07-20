# Sction 1
## criando model c/ migration
	php artisan make:model Product -m
	
## criando o controller c/ todos os metodos
	php artisan make:controller ProductController -r

## Bug na migrate
	Schema::defaultStringLength(191);
	https://github.com/laravel/framework/issues/17508

## End-Point
	http://localhost:8000/api/v1/products

## bug 
	No application encryption key has been specified. New Laravel app
	https://stackoverflow.com/questions/44839648/no-application-encryption-key-has-been-specified-new-laravel-app



# Sction 2
# Libs PDF => instalados pacotes via composer
    https://packagist.org/packages/codedge/laravel-fpdf
    https://packagist.org/packages/anouar/fpdf