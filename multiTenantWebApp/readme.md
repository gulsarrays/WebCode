This the Proof Of Concept (POC) for multitenant Web Application on default laravel 5.6

Steps
---------

1) Clone the code and run composer install/update
2) run all the migration files from database/migrations 
3) Whenever we create new user, a new db will get created with the name as "web_app_tenant_[user_id]", 
   here user_id is actual userID from user table
4) In that new db, I am creating a  sample "posts" table and adding dummy record data by appending user_id and user_name in data.
5) Whenever we create new account, after creating new db and adding record in 'posts' table, 
   we will get redirect to home page where we can see the data from the "web_app_tenant_[user_id]" DB.
6) Even agter logout, if we again login, on home page, it will show the data from "web_app_tenant_[user_id]" DB only.