<?php

namespace Smarteknoloji\SmartInstaller\Controllers;

use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{

    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $acceptLang = \Request::server('HTTP_ACCEPT_LANGUAGE');
        foreach ($this->parse(\Arr::wrap($acceptLang)) as $locale => $quality) {
            $locale = \Str::before($locale, '-');

            //save lang
            app()->setLocale($locale);
            session()->put('locale', $locale);

            break;
        }

        return view('vendor.installer.welcome');
    }

    protected function parse(array $acceptLanguage): array
    {
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', \Arr::first($acceptLanguage), $matches);

        if (empty($matches[1])) {
            return [];
        }

        /** @var array<string, string> $locales */
        $locales = array_combine($matches[1], $matches[4]) ?: [];

        foreach ($locales as $locale => $quality) {
            if ($quality === '') {
                $locales[$locale] = 1;
            }

            if (\Str::contains($locale, '-')) {
                $lang = \Str::before($locale, '-');

                $locales[$lang] ??= 0;
            }
        }

        arsort($locales, SORT_NUMERIC);

        return array_map('floatval', $locales);
    }

}
