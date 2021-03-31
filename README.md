# Installation Guide
## Installation : Clone the Repository

```
 git clone https://github.com/Ngizeh/ycode-test.git

```

Navigate to the project folder

```
 cd path/to/your/project
```

On the project folder run the following command on the terminal

```
 composer install
```

- Copy `.env.example` contents to `.env` 

- Add your Airtable API KEY and fill your values. The grid table name should be inside the quotes

```
    AIRTABLE_KEY=//YOUR API KEY
    AIRTABLE_ID=//YOUR API ID
    AIRTABLE_TABLE="//YOUR AIRTABLE BASE NAME"
```

- Run this command on your terminal
(`php artisan key:generate`)

- Run `php artisan clear:cache` to clear cached data

Finally,serve your Application on localhost:) http://localhost:8000
- If you don't have valet installed in your machine. Use this command on your terminal
```
  php artisan serve
```

### Note:
Airtable requires the application to have secure(installed SSL) URL in order to preview the uploaded images.
