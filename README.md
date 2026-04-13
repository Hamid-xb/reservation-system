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

### 3. Start the application 
```bash
sail up -d
```

### 4. Install dependencies
```bash
sail composer install
```
### 5. Generate application key
```bash
sail artisan key:generate
```

### 6. Run database migrations
```bash
sail artisan migrate
```

### Run NPM
```bash
sail npm install
sail npm run dev
```

## Running the project

### Start the containers:
```bash
sail up -d
```

#### Open in browser:
```bash
http://localhost
```

### Stop the project:
```bash
sail down
```


## Useful commands
### Run Artisan commands:
```bash
sail artisan <command>
```

### Run Composer commands: 
```bash
sail composer <command>
```

## Notes

- The `.env` file must NOT be committed to version control.
- Use `.env.example` as the template for local configuration.
- Ensure Docker is running before executing Laravel Sail commands.
- Sail commands can be run using `sail` instead of `./vendor/bin/sail` by using an alias.