## Giscus

Note: As of May 8, 2019, GitHub added gist notifications natively. All GitHub users will be automatically subscribed to notifications for all *new* gists going forward, but you have to manually subscribe to old gists, so for now we've disabled gist comment notifications for all gists created on or after May 8. We're in touch with GitHub and will update our logic as we hear more from them.

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
cp .env.example .env
```

- Generate application key:

```bash
php artisan key:generate
```

- Create a [new OAuth App](https://github.com/settings/applications/new) in your github account:

- Set the Github environment variables in your `.env` file, from a [generated OAuth app](https://github.com/settings/applications/new)
> For example, if you are using [Laravel Valet](https://laravel.com/docs/valet), you likely have Giscus running on `http://giscus.test`. Your Github .env variables should look like this:

```dotenv
GITHUB_ID=someLongString
GITHUB_SECRET=someLongString
GITHUB_URL=http://giscus.test/auth/github/callback
```

- If you want the tests to work, copy `.env.test.example` to `.env.test` and set the following GitHub env var in `.env.test`, from a [generated token](https://github.com/settings/tokens):

```dotenv
TESTING_USER_GITHUB_API_TOKEN=someLongString
```
