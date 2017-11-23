<?php

if (! function_exists('asset_path')) {
    /**
     * Get the path to a versioned asset file.
     *
     * @param  string  $file
     * @return string
     */
    function asset_path($file)
    {
        $file = trim($file, '/');
        $config = config(config('services.asset-version.config', 'asset-version'));

        if ($version = array_get($config, $file)) {
            return '/'.$file.'?'.$version;
        }

        return '/'.$file;
    }
}
