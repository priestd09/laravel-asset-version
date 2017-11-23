<?php

namespace ElfSundae\Laravel\AssetVersion\Console;

use Illuminate\Console\Command;

class AssetVersionUpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'asset-version:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update asset version configuration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->updateAssetsConfiguration(
            $this->revisionAssets($this->getAssetsConfiguration())
        );

        $this->info('Asset version configuration updated!');
    }

    /**
     * Get the asset version configuration (file) name.
     *
     * @return string
     */
    protected function configName()
    {
        return $this->laravel['config']->get('services.asset-version.config', 'asset-version');
    }

    /**
     * Get the configuration file path.
     *
     * @return string
     */
    protected function configPath()
    {
        return $this->laravel->basePath().'/config/'.$this->configName().'.php';
    }

    /**
     * Get the current asset version configuration.
     *
     * @param  mixed  $default
     * @return mixed
     */
    protected function getAssetsConfiguration($default = null)
    {
        return $this->laravel['config']->get($this->configName(), $default);
    }

    /**
     * Update the asset version configuration.
     *
     * @param  array  $config
     */
    protected function updateAssetsConfiguration($config)
    {
        $this->laravel['config']->set($this->configName(), $config);

        file_put_contents(
            $this->configPath(),
            sprintf("<?php\n\nreturn %s;\n", var_export($config, true))
        );
    }

    /**
     * Revision assets.
     *
     * @param  mixed  $assets
     * @return array
     */
    protected function revisionAssets($assets)
    {
        $result = [];

        foreach ((array) $assets as $path => $version) {
            if (is_int($path)) {
                list($path, $version) = [$version, ''];
            }

            $path = trim($path, '/');

            $fullPath = $this->laravel->basePath().'/public/'.$path;

            if (is_file($fullPath)) {
                $version = substr(md5_file($fullPath), 0, 10);
            } else {
                $this->error("Revisioning file [$path] failed.");
            }

            $result[$path] = $version;
        }

        return $result;
    }
}
