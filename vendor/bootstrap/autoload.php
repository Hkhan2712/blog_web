<?php
spl_autoload_register(function ($classname) {
    $classname = ltrim($classname, '\\');
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);

    $baseDirs = [
        RootURI . 'controllers/',
        RootURI . 'controllers/admin/',
        RootURI . 'models/',
        RootURI . 'utils/',
        RootURI . 'vendor/',
    ];

    foreach ($baseDirs as $baseDir) {
        if ($baseDir == RootURI . 'vendor/') {
            if (preg_match('/Model$/', $classname)) {
                $file = $baseDir . 'models/' . $classname . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        } else {
            $file = $baseDir . $classname . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

    if (preg_match('/Model$/', $classname)) {
        $paths = [
            RootURI . 'models/' . $classname . '.php',
            RootURI . 'vendor/models/' . $classname . '.php'
        ];
        foreach ($paths as $file) {
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

    if (preg_match('/Controller$/', $classname)) {
        $file = RootURI . 'controllers/' . $classname . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    if (preg_match('/Utils?$/i', $classname)) {
        $file = RootURI . 'utils/' . $classname . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    error_log("Autoload failed: {$classname} not found.");
});
