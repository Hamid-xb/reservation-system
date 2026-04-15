# Reservation-system
A reservation tool for restaurants designed to attract more customers, streamline the booking process, and reduce errors.

---

## Requirements

- Docker Desktop
- Docker Compose
- Git

---

## Setup Instructions


### 1. Clone the repository
```bash
git clone <your-repo-url>
cd reservation-system
```

### 2. Copy the env.example
```bash
cp .env.example .env
```

### 3. Install dependecies
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### 4. Start the application 
```bash
./vendo/bin/sail up -d
```

### 5. Generate application key
```bash
./vendo/bin/sail artisan key:generate
```

### 6. Run database migrations
```bash
./vendo/bin/sail artisan migrate
```

### Run NPM
```bash
./vendo/bin/sail npm install
./vendo/bin/sail npm run dev
```

## Running the project

### Start the containers:
```bash
./vendo/bin/sail up -d
```

#### Open in browser:
```bash
http://localhost
```

### Stop the project:
```bash
./vendo/bin/sail down
```


## Useful commands
### Run Artisan commands:
```bash
./vendo/bin/sail artisan <command>
```

### Run Composer commands: 
```bash
./vendo/bin/sail composer <command>
```

## Notes

- The `.env` file must NOT be committed to version control.
- Use `.env.example` as the template for local configuration.
- Ensure Docker is running before executing Laravel Sail commands.
