Web Application to manage and categorize events built on Symfony2-CRUD (Doctrine),Twig,Bootstrap Framework

## Features 

	- View Events
	- Add Events & Categories
	- Edit Events & Categories

	
## Database Configuration

	Edit file :  app/config/parameters.yml

```
	database_host:     127.0.0.1
    database_port:     3306
    database_name:     eventcal
    database_user:     -
	database_password: - 
```	
	
```	
	$ php app/console doctrine:schema:update --force
```	
	
## Run : 

```
	$ php app/console server:run
```	