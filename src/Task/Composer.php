<?php

namespace Sunaoka\Holidays\Task;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Composer
{
    /**
     * @param Filesystem|null $filesystem
     *
     * @return void
     */
    public static function removeHolidays(Event $event, $filesystem = null)
    {
        $composer = $event->getComposer();
        $extra = $composer->getPackage()->getExtra();

        /** @var array $keep */
        $keep = isset($extra['sunaoka/holidays']) ? $extra['sunaoka/holidays'] : [];
        if (count($keep) === 0) {
            return;
        }

        $keep = array_map(static function ($country) {
            /** @var string $country */
            return strtolower($country);
        }, $keep);

        /** @var string $vendorDir */
        $vendorDir = $composer->getConfig()->get('vendor-dir');
        $configDir = "{$vendorDir}/sunaoka/holidays/config";
        $dataDir = "{$vendorDir}/sunaoka/holidays/src/data";

        $finder = (new Finder())
            ->files()
            ->depth('== 0')
            ->in([$configDir, $dataDir]);

        $filesystem = $filesystem ?: new Filesystem();

        $remove = [];
        foreach ($finder as $file) {
            $country = $file->getBasename('.php');
            if (in_array($country, $keep, true)) {
                continue;
            }

            $remove[] = $country;
            $filesystem->remove($file->getRealPath());
        }

        sort($remove);
        $remove = array_unique($remove);

        foreach ($remove as $country) {
            $event->getIO()->write("Removed `{$country}' holidays.");
        }
    }
}
