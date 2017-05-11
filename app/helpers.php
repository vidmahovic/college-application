<?php

use \Illuminate\Support\HtmlString;
use \Illuminate\Contracts\Auth\Factory as AuthFactory;

if (!function_exists('resource')) {
    function resource($basePath, $controller = null) {
        $app = app();
        $controller = $controller ?? title_case(
                str_replace('-', '', $basePath)
            ) . 'Controller';
        $app->get("$basePath", "{$controller}@index");
        $app->get("$basePath/{id}", "{$controller}@show");
        $app->put("$basePath/{id}", "{$controller}@update");
        $app->post("$basePath", "{$controller}@store");
        $app->delete("$basePath/{id}", "{$controller}@destroy");
    }
}

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

if(! function_exists('mix')) {
    /**
     * Get the path to a versioned Mix file.
     *
     * @param  string  $path
     * @param  string  $manifestDirectory
     * @return \Illuminate\Support\HtmlString
     *
     * @throws \Exception
     */
    function mix($path, $manifestDirectory = '')
    {
        static $manifest;

        if (! starts_with($path, '/')) {
            $path = "/{$path}";
        }

        if ($manifestDirectory && ! starts_with($manifestDirectory, '/')) {
            $manifestDirectory = "/{$manifestDirectory}";
        }

        if (file_exists(public_path($manifestDirectory.'/hot'))) {
            return new HtmlString(env('APP_URL', 'http://localhost') . ":8080{$path}");
        }

        if (! $manifest) {
            if (! file_exists($manifestPath = public_path($manifestDirectory.'/mix-manifest.json'))) {
                throw new Exception('The Mix manifest does not exist.');
            }

            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        if (! array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unable to locate Mix file: {$path}. Please check your ".
                'webpack.mix.js output paths and try again.'
            );
        }

        return new HtmlString($manifestDirectory.$manifest[$path]);
    }
}

if (! function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @param  string|null  $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth($guard = null)
    {
        if (is_null($guard)) {
            return app(AuthFactory::class);
        } else {
            return app(AuthFactory::class)->guard($guard);
        }
    }
}

if(!function_exists('bcrypt')) {

    function bcrypt($value, $params = [])
    {
        return app('hash')->make($value, $params);
    }

}

//if(! function_exists('config_path')) {
//
//    function config_path($path = '') {
//        return rtrim(app()->basePath('config/' . $path), '/');
//    }
//
//}


