# Job Nest

Job Nest is a modern web application designed to connect job seekers with employers. It features an intuitive interface for browsing and applying to jobs, as well as advanced AI-powered job recommendations and resume parsing. The project is built with Laravel (PHP) for the backend and Vue.js for the frontend, styled with Tailwind CSS.

## Features

### For Job Seekers
- **Browse Jobs:** Explore a wide range of job listings posted by companies.
- **Apply for Jobs:** Submit applications directly through the platform.
- **AI Job Recommendations:** Receive personalized job suggestions powered by generative AI.
- **Resume Text Parsing:** Upload your resume content and let the AI extract and analyze your skills and experience for better job matching.

### For Companies
- **Post Jobs:** Create and manage job listings to attract potential candidates.
- **View Posted Jobs:** See all jobs your company has posted.
- **(To-be-implemented) Application Management:** Features to track and manage applications.

## AI Integration
The AI features (job recommendations and resume parsing) are powered by a FastAPI backend deployed at [https://fast-api-ai.vercel.app/docs](https://fast-api-ai.vercel.app/docs). The source code for the AI service is available at [https://github.com/Radowan30/job-nest-fast-api-ai](https://github.com/Radowan30/job-nest-fast-api-ai).

## Tech Stack
- **Backend:** Laravel 12
- **Frontend:** Vue.js 
- **Styling:** Tailwind CSS
- **Build Tool:** Vite
- **Database:** Supabase
- **AI Service:** FastAPI (Python)

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- Supabase project
### Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-username/job-nest.git
   cd job-nest
   ```

2. **Install PHP dependencies:**
   ```sh
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```sh
   npm install
   ```

4. **Copy and configure environment file:**
   ```sh
   cp .env.example .env
   # Edit .env to set your database and other environment variables
   # For Supabase, refer to the Supabase environment settings mentioned in the section below.
   ```

5. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

6. **Run migrations:**
   ```sh
   php artisan migrate
   ```

7. **Build frontend assets:**
   ```sh
   npm run build
   ```

8. **Start the development server:**
   ```sh
   php artisan serve
   ```
   The app will be available at [http://localhost:8000](http://localhost:8000).

### (Optional) Running the AI Service Locally
If you want to run the AI backend locally, clone and follow the instructions at [https://github.com/Radowan30/job-nest-fast-api-ai](https://github.com/Radowan30/job-nest-fast-api-ai).

## Using Supabase with Laravel

This project uses [Supabase](https://supabase.com/) as its Postgres database backend. Below are the steps and tips for setting up and connecting your Laravel app to Supabase, adapted from the official Supabase Laravel quickstart:

### 1. Create a Supabase Project
- Go to [database.new](https://database.new/) and create a new Supabase project.
- Save your database password securely.
- In your Supabase dashboard, click on **Connect** and copy the **Session Pooler** connection string. Replace the password with your saved password.

### 2. Configure Laravel to Use Supabase
- In your `.env` file, set the following:
  ```env
  DB_CONNECTION=pgsql
  DB_URL=postgresql://<username>:<password>@<host>:<port>/<database>
  ```
  (Replace with your actual Supabase credentials.)

### 3. Run Migrations
Run the following command to set up your database tables:
```sh
php artisan migrate
```

### 4. Start the App
Run the development server:
```sh
php artisan serve
```
Visit [http://localhost:8000](http://localhost:8000) to view your app.

---
For more details, see the [Supabase Laravel Quickstart](https://supabase.com/docs/guides/getting-started/quickstarts/laravel).

## Contributing
Contributions are welcome! Please open issues or submit pull requests for new features, bug fixes, or improvements.

