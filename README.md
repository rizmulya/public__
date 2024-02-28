# public__

Laravel public path but protected, only accessible by verified credentials and prevent asset access from the url.

## how to use
1. install
```
composer require rizmulya/protected-public
```

2. set .env (allowed domain & extention, and public url)

```
PUBLIC_URL="/x"
PUBLIC_DOMAINS="https://yourdomain.com"
PUBLIC_EXTS="css|js|ico|png|jpg"
```

3. use with `public__::set()` at route/web.php

```
Route::get(env('PUBLIC_URL') . '/{path}', function ($path) {
    return public__::set($path);
})->where('path', '.*');
```

4. use with `public__::get()` at views src

```
<link href="{{ public__::get('style.css') }}" rel="stylesheet" />

<script src="{{ public__::get('main.js') }}"></script>
```

5. finally create and place the files you want to protect in `public__` and not in `public` 
