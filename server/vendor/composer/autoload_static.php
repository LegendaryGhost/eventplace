<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit675531aa64c2cf046fabf107bee1d33b
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Rihantiana\\Server\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Rihantiana\\Server\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit675531aa64c2cf046fabf107bee1d33b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit675531aa64c2cf046fabf107bee1d33b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit675531aa64c2cf046fabf107bee1d33b::$classMap;

        }, null, ClassLoader::class);
    }
}
