<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited1663aa7d7d04826ee35c15d5d3d3d8
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symphony\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symphony\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited1663aa7d7d04826ee35c15d5d3d3d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited1663aa7d7d04826ee35c15d5d3d3d8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited1663aa7d7d04826ee35c15d5d3d3d8::$classMap;

        }, null, ClassLoader::class);
    }
}