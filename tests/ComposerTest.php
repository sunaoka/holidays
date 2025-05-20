<?php

namespace Sunaoka\Holidays\Tests;

use Composer\Config;
use Composer\IO\ConsoleIO;
use Composer\Package\RootPackage;
use Composer\Script\Event;
use Sunaoka\Holidays\Task\Composer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ComposerTest extends TestCase
{
    /**
     * @return void
     */
    public function testRemoveHolidaysSuccess()
    {
        $vendorDir = sys_get_temp_dir() . '/holidays-vendor-' . mt_rand();
        $configDir = "{$vendorDir}/sunaoka/holidays/config";
        $dataDir = "{$vendorDir}/sunaoka/holidays/src/data";

        $filesystem = new Filesystem();
        $filesystem->mkdir($configDir);
        $filesystem->mkdir($dataDir);

        $countries = ['jp', 'us', 'lu'];

        foreach ($countries as $country) {
            $filesystem->touch("{$configDir}/{$country}.php");
            $filesystem->touch("{$dataDir}/{$country}.php");
        }

        $keep = ['jp'];

        Composer::removeHolidays(
            $this->getMockEvent($countries, $keep, $vendorDir),
            $filesystem
        );

        $finder = (new Finder())
            ->files()
            ->depth('== 0')
            ->in([$configDir, $dataDir]);

        foreach ($finder as $file) {
            $country = $file->getBasename('.php');
            self::assertContains($country, $keep);
        }
    }

    /**
     * @return void
     */
    public function testRemoveHolidaysWithoutExtraSuccess()
    {
        $vendorDir = sys_get_temp_dir() . '/holidays-vendor-' . mt_rand();
        $configDir = "{$vendorDir}/sunaoka/holidays/config";
        $dataDir = "{$vendorDir}/sunaoka/holidays/src/data";

        $filesystem = new Filesystem();
        $filesystem->mkdir($configDir);
        $filesystem->mkdir($dataDir);

        $countries = ['jp', 'us', 'lu'];

        foreach ($countries as $country) {
            $filesystem->touch("{$configDir}/{$country}.php");
            $filesystem->touch("{$dataDir}/{$country}.php");
        }

        Composer::removeHolidays(
            $this->getMockEvent($countries, [], $vendorDir),
            $filesystem
        );

        $finder = (new Finder())
            ->files()
            ->depth('== 0')
            ->in([$configDir, $dataDir]);

        foreach ($finder as $file) {
            $country = $file->getBasename('.php');
            self::assertContains($country, $countries);
        }
    }

    /**
     * @param string $vendorDir
     *
     * @return Event
     */
    private function getMockEvent(array $all, array $keep, $vendorDir)
    {
        $package = \Mockery::mock(RootPackage::class)
            ->shouldReceive('getExtra')
            ->andReturn(['sunaoka/holidays' => $keep])
            ->getMock();

        $config = \Mockery::mock(Config::class)
            ->shouldReceive('get')
            ->with('vendor-dir')
            ->andReturn($vendorDir)
            ->getMock();

        $composer = \Mockery::mock(\Composer\Composer::class)
            ->shouldReceive('getPackage')
            ->andReturn($package)
            ->getMock()
            ->shouldReceive('getConfig')
            ->andReturn($config)
            ->getMock();

        $io = \Mockery::mock(ConsoleIO::class);

        foreach (array_diff($all, $keep) as $country) {
            $io->shouldReceive('write')
                ->once()
                ->with("Removed `{$country}' holidays.")
                ->getMock();
        }

        /** @var Event */
        return \Mockery::mock(Event::class)
            ->shouldReceive('getComposer')
            ->andReturn($composer)
            ->getMock()
            ->shouldReceive('getIO')
            ->andReturn($io)
            ->getMock();
    }
}
