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
    
  
  
  ## test Token
      {
          "token_type": "Bearer",
          "expires_in": 1799,
          "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI2NzFjOTk4MGM5MzE4MmViMWZjZWM5Njk2NDI0MjNjN2M5OTYyZThhNTA3NWZhMjc5NjNmOTFiMjA3ZDFkZjYwOTFlMTVmMzk4MDlkNjc1In0.eyJhdWQiOiIzIiwianRpIjoiYjY3MWM5OTgwYzkzMTgyZWIxZmNlYzk2OTY0MjQyM2M3Yzk5NjJlOGE1MDc1ZmEyNzk2M2Y5MWIyMDdkMWRmNjA5MWUxNWYzOTgwOWQ2NzUiLCJpYXQiOjE1MzIzNTQwMjgsIm5iZiI6MTUzMjM1NDAyOCwiZXhwIjoxNTMyMzU1ODI3LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.jMWJaeDiYQunJRwGo1tf3S0zR5VOGrjkkxh3mdWzyPJEVz06tALJg3xNbQ99DO7bpBTtisqpVKm49VlhAd0omPOiRciqmr6FPkDL-n_sNlW7SC-FCaeHOUMtAg5ACW_LHWgGuLd6g9alylnHKE6IaMmWN_4KSQp_tqv0WzZbT0ebzjMq8pyXcCEpzDCYVFigAFU8xE2kF3QfgmVGV5_lq_0aqA0oEhdsL3pz72ylSt0I_LxVYCqhC6e895jhApTtWDKnS5-_q0BItYplo_llN0H-KIB2DN0Ki4Xhnp4lxpfPwIcZS7dS8vqW1g8Y5gKxMdbX-mq3zaWubZsmQmElyJOqrZygml5nxRtjMolVi5jQLjD3dqCxYKaf6CNDkjFLXv1OBEFZZXsRQHyr1fy7_luQjVm3lM_NpkT2wEhU4DaCCuxeQ72zQIzw8528aQo97kXjfiB6ErqkG71plznxjCqX3PsYaXpwrYYbhXdKL8lSN0kJ6Vd017cBK0cbrDxLnvR_Q0qg-TY2Y-c4O2hwMKetqR9WpdyZ6UkXqv_dIXzerl4c5VkquqLJBD4IN5lMVwadNjL2kitJH992ITJ56-yQKUWLkAwlsPquyfWBOuIuTTaOUqOwjeH3-l6JQJ3kTZIVTMiDbaC9CgFN3AyDJYcasnP1VCMZjYbwLQlqo7U"
      }