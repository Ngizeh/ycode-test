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

Install the project dependencies


```
 npm install && npm run dev
```

 or

 If you have yarn installed

```
 yarn install && yarn run dev
```

- Copy `.env.example` contents to `.env` 

- Add your Airtable API KEY and fill your values

```
    AIRTABLE_KEY=//YOUR API KEY
```

- Run this command on your terminal
(`php artisan key:generate`)

Finally,serve your Application on localhost:) http://localhost:8000
- If you don't have valet installed in your machine. Use this command on your terminal
```
  php artisan serve
```

### Note:
Airtable requires the application to have secure(installed SSL) URL in order to preview the uploaded images.
