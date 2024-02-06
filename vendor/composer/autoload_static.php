<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9612c1228beb02b88d03ac0b2b90ede3
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sonata\\GoogleAuthenticator\\' => 27,
        ),
        'G' => 
        array (
            'Google\\Authenticator\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sonata\\GoogleAuthenticator\\' => 
        array (
            0 => __DIR__ . '/..' . '/sonata-project/google-authenticator/src',
        ),
        'Google\\Authenticator\\' => 
        array (
            0 => __DIR__ . '/..' . '/sonata-project/google-authenticator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9612c1228beb02b88d03ac0b2b90ede3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9612c1228beb02b88d03ac0b2b90ede3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9612c1228beb02b88d03ac0b2b90ede3::$classMap;

        }, null, ClassLoader::class);
    }
}
