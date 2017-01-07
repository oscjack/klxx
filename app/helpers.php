<?php
if (! function_exists('asset_url')) {
    function asset_url($path, $secure = null)
    {
        $url = app('url')->asset($path, $secure);

        $public_path = public_path();

        if (asset_exists($path)) {
            $url .= '?' . filemtime($public_path . '/' . $path);
        }

        return $url;
    }
}

if (! function_exists('asset_exists')) {
    function asset_exists($path)
    {
        $public_path = public_path();

        if (file_exists($public_path . '/' . $path)) {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('debug')) {
    function debug($message, $trace = false) {
        $fp = fopen(storage_path('logs/debug.log'), 'a+');

        Kint::enabled(Kint::MODE_WHITESPACE);

        $output = Kint::dump($message);

        if ($trace) {
            $trace = Kint::trace();

            $output .= "\n" . $trace;
        }

        fwrite($fp, $output);
        fclose($fp);
    }
}
