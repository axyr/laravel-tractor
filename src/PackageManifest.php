<?php

namespace Axyr\CrudGenerator;

use Illuminate\Foundation\PackageManifest as BasePackageManifest;
use Illuminate\Support\Arr;

/**
 * This extends adds merges the module composer.json extra values into the code manifest.
 * This is done to autoload the providers and add the dont-discover provider settings.
 *
 * As Laravel has its own way of reading these values, we need to merge in these custom values some how.
 * Warning: hacky stuff, can be done better for sure...
 */
class PackageManifest extends BasePackageManifest
{
    public function pluginComposerFiles(): array
    {
        $globPatterns = json_decode(
            file_get_contents(
                base_path('composer.json')
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        )['extra']['merge-plugin']['include'] ?? [];

        $files = [];

        foreach ($globPatterns as $globPattern) {
            $files = array_unique(array_merge($files, glob($globPattern)));
        }

        return $files;
    }

    public function modules()
    {
        $modules = [];

        foreach ($this->pluginComposerFiles() as $composerPath) {
            $modules[] = json_decode(file_get_contents($composerPath), true);
        }

        return $modules;
    }

    public function packagesToIgnore()
    {
        $ignore = [];

        foreach ($this->pluginComposerFiles() as $composerPath) {
            $ignore[] = $this->extractToIgnorePackagesFromComposerFile($composerPath);
        }

        return array_unique(array_merge(parent::packagesToIgnore(), Arr::flatten($ignore)));
    }

    public function extractToIgnorePackagesFromComposerFile(string $composerPath)
    {
        $composer = json_decode(file_get_contents($composerPath), true);

        return $composer['extra']['laravel']['dont-discover'] ?? [];
    }

    public function collectProvidersFromModules(): array
    {
        $include = [];
        $packagesToIgnore = $this->packagesToIgnore();

        foreach ($this->modules() as $module) {
            $providers = $module['extra']['laravel'] ?? [];
            foreach ($providers['providers'] ?? [] as $index => $provider) {
                if (in_array($provider, $packagesToIgnore, true)) {
                    unset($providers['providers'][$index]);
                }
            }

            if (count($providers['providers'] ?? [])) {
                $include[$this->format($module['name'])] = $providers;
            }
        }

        return $include;
    }

    protected function write(array $manifest)
    {
        parent::write(array_merge($manifest, $this->collectProvidersFromModules()));
    }

    public function build()
    {
        return tap(parent::build(), function () {
            $this->getManifest();
        });
    }
}
