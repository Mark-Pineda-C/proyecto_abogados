<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0f997c9132cfa51ee6f0742292df7e99
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0f997c9132cfa51ee6f0742292df7e99::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0f997c9132cfa51ee6f0742292df7e99::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0f997c9132cfa51ee6f0742292df7e99::$classMap;

        }, null, ClassLoader::class);
    }
}
