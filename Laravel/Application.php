<?php

namespace Bitaac\Laravel;

use Illuminate\Foundation\Application as Base;

class Application extends Base
{
    /**
     * The custom application config path defined by the developer.
     *
     * @var string
     */
    protected $configPath;

    /**
     * Set the application config directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useConfigPath($path)
    {
        $this->configPath = $path;

        $this->instance('path.config', $path);

        return $this;
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
    	return ($this->configPath ?: $this->basePath.DIRECTORY_SEPARATOR.'config').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
    	return $this->path('resources/lang');
    }
}
