# Symfony-Form

This is a project to test fields of a form with different data.

Each data has a constraint to be validated before insertion into database.

Get the dependencies and follow instructions:

1. Create database in MySQL
```bash
symfony console doctrine:database:create
```

2. Execute migration
```bash
symfony console doctrine:migrations:migrate
```

3. Run the app
```bash
symfony server:start
```

Now, we can test the form.