1. install socialite package
    composer require laravel/socialite
2. configure socialite in config/services.php
   'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    
3. add env variables in .env file
    APP_URL=http://localhost:8000
    GOOGLE_CLIENT_ID=186743744428-hg7a6kmpf8eek5lohf78frmu8af5r1i0.apps.googleusercontent.com
    GOOGLE_CLIENT_SECRET=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
    GOOGLE_REDIRECT_URI=${APP_URL}/auth/google/callback