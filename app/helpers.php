<?php
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


