<?php

// namespace rizmulya\ProtectedPublic;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class public__
{
    public static function set($path)
    {
        $allowedDomains = explode('|', env('PUBLIC_DOMAINS'));
        $allowedExtensions = explode('|', env('PUBLIC_EXTS'));
        $referer = Request::header("referer");
        $domainAllowed = false;
        foreach ($allowedDomains as $domain) {
            if (Str::startsWith($referer, $domain)) {
                $domainAllowed = true;
                break;
            }
        }
        !$domainAllowed
            && abort(403);

        $extensionsPattern = implode('|', $allowedExtensions);
        !preg_match('/^[a-zA-Z0-9_\-\/]+(\.[a-zA-Z0-9_\-]+)*\.(' . $extensionsPattern . ')$/', $path)
            && abort(403);

        $baseDir = realpath(base_path(__CLASS__));
        $safePath = realpath($baseDir . '/' . $path);

        return $safePath
            && Str::startsWith($safePath, $baseDir)
            && File::exists($safePath)
            ? response()->file($safePath)
            : abort(404);
    }

    public static function get($path)
    {
        return env('PUBLIC_URL') . "/" . $path;
    }
}
