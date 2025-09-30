<p align="center"><a href="https://reftecindustrial.com" target="_blank"><img src="https://temp.reftecindustrial.com/images/reftec_logo_notext.svg" width="400" alt="Reftec Logo"></a></p>

# Reftec Industrial Supply and Services Inc.  

A web application built with **Laravel** and styled using **TailwindCSS**.  
This project powers the digital platform for **Reftec Industrial Supply and Services Inc.**, providing scalable, maintainable, and modern solutions for internal operations and customer-facing services.  

---

## 🚀 Features  

- Built with **Laravel 12** (latest stable)  
- Frontend styled with **TailwindCSS**  
- Modular Blade components for reusability  
- Optimized build process with **Vite**  
- Responsive design for desktop and mobile  

---

## 📂 Project Structure  

```text
├── app/                # Application core (Models, Controllers, Services)
├── bootstrap/          # Laravel bootstrap files
├── config/             # Application configuration
├── database/           # Migrations, factories, and seeders
├── public/             # Public-facing files (index.php, assets)
├── resources/
│   ├── css/            # TailwindCSS styles
│   ├── js/             # JavaScript / Alpine.js
│   ├── views/          # Blade templates
│   └── components/     # Custom Blade components
├── routes/
│   └── web.php         # Web routes
├── storage/            # Logs, cache, and file storage
├── tests/              # Unit and feature tests
└── vite.config.js      # Vite configuration
```

---

## ⚙️ Installation  

### Prerequisites  
Make sure you have the following installed:  
- PHP >= 8.2  
- Composer  
- Node.js & npm  
- MySQL or other supported database  

### Steps  

1. Clone the repository:  

        git clone https://github.com/reftec-it/reftecindustrial_website.git
        cd reftecindustrial_website

2. Install PHP dependencies:  

        composer install

3. Install JS dependencies:  

        npm install

4. Copy `.env.example` to `.env` and update configuration (database, app URL, etc.):  

        cp .env.example .env

5. Generate application key:  

        php artisan key:generate

6. Run migrations (and seed if needed):  

        php artisan migrate --seed

7. Start the development server:  

        php artisan serve

8. Build frontend assets:  

        npm run dev   # for development
        npm run build # for production

---

## 🛠️ Development Notes  

- Use **Alpine.js** for lightweight interactivity.  
- Keep Blade templates clean by extracting reusable components into `resources/views/components`.  
- TailwindCSS utility classes handle most styling, with minimal custom CSS.  

---

## 📜 License  

This project is proprietary software for **Reftec Industrial Supply and Services Inc.**  
All rights reserved.  
