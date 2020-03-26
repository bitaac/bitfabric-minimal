<?php

namespace Bitaac\Theme\Http\Controllers;

use Exception;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\File;
use Bitaac\Laravel\Http\Controllers\Controller;

class ThemeAssetsController extends Controller
{
    /**
     * Retrieve theme assets.
     *
     * @param  string  $asset
     * @return response
     */
    public function handle($asset)
    {
        $asset = str_replace(DIRECTORY_SEPARATOR, '.', $asset);

        try {
            $files = [];

            $themePath = app_path('themes/'.config('bitaac.app.theme').'/public');

            foreach (Finder::create()->files()->in($themePath) as $file) {
                $directory = $this->getNestedDirectory($file, $themePath);

                $files[$directory.basename($file->getRealPath())] = $file->getRealPath();
            }

            if (! isset($files[$asset])) {
                abort(404);
            }

            return response()->file($files[$asset], [
                'Content-Type' => $this->getMimetypeFromFile($files[$asset]),
            ]);
        } catch (Exception $exception) {
            abort(404);
        }
    }

    /**
     * Retrieve the mime type of a specific file.
     *
     * @param  string  $file
     * @return string
     */
    protected function getMimetypeFromFile($file)
    {
        $extension = File::extension($file);

        switch ($extension) {
            case 'css':     return 'text/css';
            case 'js':      return 'application/javascript';
            case 'json':    return 'application/json';
            case 'svg':     return 'image/svg+xml';
            default:
                return File::mimeType($file);
        }
    }

     /**
     * Get the given file nesting path.
     *
     * @param  \SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }
}
