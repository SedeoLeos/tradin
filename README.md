Here are the commands to start your Laravel project with Sail, run migrations, import data, and run Yarn on Sail.

### 1. Starting the Project with Laravel Sail

First, ensure you have Docker installed on your machine. Then, you can start your Laravel application using Sail.

#### Start the Containers with Sail

In your project directory, run the following command to start the Docker containers:

```bash
./vendor/bin/sail up -d
```

This will start your Laravel application in Docker containers, in the background (`-d` flag).

### 2. Running Migrations with Sail

Once the containers are up, you can run the database migrations to set up your tables:

```bash
./vendor/bin/sail artisan migrate
```

This will run the migrations defined in your Laravel project and update your database accordingly.

### 3. Importing Data

Next, to import data from the `feed.json` file, you can use the command you’ve created in your project. For example, to import articles:

```bash
./vendor/bin/sail artisan import:articles
```

This will read the `feed.json` file and insert articles and their associated content into the database.

### 4. Running Yarn (for front-end)

If you're using front-end tools like Vue.js, React, or others with Laravel, you can run Yarn to install dependencies and start the build process.

#### Install Front-end Dependencies with Yarn

```bash
./vendor/bin/sail yarn install
```

#### Start the Front-end Development Server with Yarn

After installing the dependencies, run the development server for the front-end:

```bash
./vendor/bin/sail yarn dev
```

This will start the front-end development server, allowing you to work on your application's front-end.

### Summary of Commands

1. **Start Sail (containers)**:

    ```bash
    ./vendor/bin/sail up -d
    ```

2. **Run Migrations**:

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

3. **Import Data (articles)**:

    ```bash
    ./vendor/bin/sail artisan import:articles
    ```

4. **Install Front-end Dependencies with Yarn**:

    ```bash
    ./vendor/bin/sail yarn install
    ```

5. **Start Front-end Development Server with Yarn**:
    ```bash
    ./vendor/bin/sail yarn dev
    ```

These steps should allow you to start the application, run migrations, import data, and manage the front-end with Sail in a Docker environment.
