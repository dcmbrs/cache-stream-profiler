# How to reproduce

## Prerequisites
Run `composer install` to install all dependencies.

Start symfony local server web : `symfony server:start`

Cache is configured in `config/packages/cache.yaml` with filesystem adapter.

## Run bug reproduction
Go to the url : `https://127.0.0.1:8000/stream` to run stream example.  
Next go to cache panel profiler corresponding to your request `https://127.0.0.1:8000/_profiler/latest?type=request&panel=cache`
 - `cache.app` is not present in the panel
 - but it's working for http client for example

## Expected behavior
If you run home page `https://127.0.0.1:8000/` for example, and after to profiler you can see the cache.app in the panel.
 - on home page I simulate same cache call than stream page

All code are in controller `src/Controller/HomeController.php`: