<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit108ceda2b962320daffed5e01877070c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Artisticbird\\Cookies\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Artisticbird\\Cookies\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit108ceda2b962320daffed5e01877070c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit108ceda2b962320daffed5e01877070c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit108ceda2b962320daffed5e01877070c::$classMap;

        }, null, ClassLoader::class);
    }
}
