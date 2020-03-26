<?php

namespace Bitaac\Laravel\Bootstrap;

use Exception;
use Symfony\Component\Finder\Finder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as Base;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

class LoadConfiguration extends Base
{
	/**
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $repository
     * @return void
     *
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
    	$appLaravelFiles = $this->getConfigurationFiles($app->configPath('laravel'));
    	$coreLaravelFiles = $this->getConfigurationFiles(__DIR__.'/../Config');

    	$aacFiles = array_filter($this->getConfigurationFiles($app->configPath()), function ($path, $key) {
    		return strpos($key, 'laravel.') === false;
    	}, ARRAY_FILTER_USE_BOTH);

        if (! isset($appLaravelFiles['app']) && ! isset($coreLaravelFiles['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($coreLaravelFiles as $key => $path) {
        	$coreFile = (isset($appLaravelFiles[$key]) && is_array($content = require $appLaravelFiles[$key])) ? $content : [];

            $repository->set($key, array_merge(require $path, $coreFile));
        }

        foreach ($aacFiles as $key => $path) {
            $repository->set('bitaac.'.$key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  string|null                                   $namespace
     * @return array
     */
    protected function getConfigurationFiles($path, $namespace = null)
    {
        $files = [];

        $configPath = realpath($path);

        if (! file_exists($configPath)) {
        	return [];
        }

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }
}
