<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit11bce7842b5ae24fae972837834a8c5d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit11bce7842b5ae24fae972837834a8c5d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit11bce7842b5ae24fae972837834a8c5d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}