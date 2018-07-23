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
    

## problemas na intslação do LaavelPassport, foi instalado esa dependencia
    https://github.com/paragonie/random_compat/issues/143
    composer.require = "paragonie/random_compat": "^2.0"
## versao do passport
    https://github.com/laravel/passport/issues/644 
    composer require laravel/passport:~4.0
    
## Keys Passport
    λ php artisan passport:install
    Encryption keys generated successfully.
    Personal access client created successfully.
    Client ID: 1
    Client Secret: 46WNCfpyVELWav703nEadXBV3irMGWWgkQVPWAKP
    Password grant client created successfully.
    Client ID: 2
    Client Secret: Jjzmyu6KBVZdebzwgzdp7J9pFvSxzPProeVjBlMI

## gerando um cliente 
    php artisan passport:client
    
    /* resultado */
    Client ID: 3
    Client secret: tlATCF6MUGBqpCHGo74joGPyfb9f210RcoftUYSJ
    

## Test in Postman
    
    #####################
    #  Gerando o token  #
    #####################
    // POST http://localhost:8000/api/v1/oauth/token
    //
    // =============== form-data ===============
    grant_type        :client_credentials
    client_id         :3
    client_secret     :tlATCF6MUGBqpCHGo74joGPyfb9f210RcoftUYSJ
    
    
        // =============== form-data ===============
        grant_type        :password
        client_id         :3
        client_secret     :tlATCF6MUGBqpCHGo74joGPyfb9f210RcoftUYSJ
   
   
    
    ##################################
    #  Acessando uma rota protegida  #
    ##################################
    // POST http://localhost:8000/api/v1/Rota-protegida
    //
    // para acessar a rota deves enviar
    // nos headers da requisição o token
    //
    // =============== Headers ===============
    Authorization        :Bearer +Token