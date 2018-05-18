This the Proof Of Concept (POC) for **multitenant Web Application** on default laravel 5.6 With ACL

For ACL, I used **Spatie Laravel-Permission package** you can find it on github
https://github.com/spatie/laravel-permission

I am adding **"SAMPLE_DB"** folder containg the sql files. jusr run those sql files in DB.
And you can login as admin@admin.com/password.



Steps
---------

1) Clone the code and **run composer install**
2) run all the migration files from database/migrations **php artisan migrate**
3) run the seed files as **php artisan db:seed**
3) Whenever we create new user, a new db will get created with the name as "web_app_tenant_[user_id]", 
   here user_id is actual userID from user table
4) In that new db, I am creating a  sample "posts" table and adding dummy record data by appending user_id and user_name in data.
5) Whenever we create new account, after creating new db and adding record in 'posts' table, 
   we will get redirect to home page where we can see the data from the "web_app_tenant_[user_id]" DB.
6) Even after logout, if we again login, on home page, it will show the data from "web_app_tenant_[user_id]" DB only.