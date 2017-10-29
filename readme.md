## Giscus

https://speakerdeck.com/mattstauffer/leveraging-laravel-launching-side-projects-quickly-with-laravel

https://giscus.co/

Looking for the code when it was using Cashier & Stripe? Check the [Archive-Cashier branch](https://github.com/tightenco/giscus/tree/archive/cashier).

### Local Development Setup:

- Download dependencies:

```bash
composer install
yarn
```

- Copy .env.example to .env:

```bash
cp .env.example.env
```

- Generate application key:

```bash
php artisan key:generate
```

- Create a [new OAuth App](https://github.com/settings/applications/new) in your github account:

- Set the Github environment variables in your .env file
> For example, if you are using [Laravel Valet](https://laravel.com/docs/5.5/valet), you likely have Giscus running on `http://giscus.dev`. Your Github .env variables should look like this:

```dotenv
GITHUB_ID=someLongString
GITHUB_SECRET=someLongString
GITHUB_URL=http://giscus.dev/auth/github/callback
```
