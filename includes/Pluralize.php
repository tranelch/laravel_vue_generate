<?php

/**
 * This class is a port of the Ruby on Rails Inflector class. From the docs:
 *
 * > Defines the standard inflection rules. These are the starting point for
 * > new projects and are not considered complete. The current set of inflection
 * > rules is frozen. This means, we do not change them to become more complete.
 * > This is a safety measure to keep existing applications from breaking.
 *
 * source: https://github.com/rails/rails/blob/main/activesupport/lib/active_support/inflections.rb
 **/

class Inflector
{
    private static $irregulars = [
        "person" => "people",
        "man" => "men",
        "child" => "children",
        "sex" => "sexes",
        "move" => "moves",
        "zombie" => "zombies",
    ];

    private static $uncountables = [
        'equipment' => true,
        'information' => true,
        'rice' => true,
        'money' => true,
        'species' => true,
        'series' => true,
        'fish' => true,
        'sheep' => true,
        'jeans' => true,
        'police' => true,
    ];

    private static $plurals = [
        '/$/' => "s",
        '/s$/i' => "s",
        '/^(ax|test)is$/i' => '\1es',
        '/(octop|vir)us$/i' => '\1i',
        '/(octop|vir)i$/i' => '\1i',
        '/(alias|status)$/i' => '\1es',
        '/(bu)s$/i' => '\1ses',
        '/(buffal|tomat)o$/i' => '\1oes',
        '/([ti])um$/i' => '\1a',
        '/([ti])a$/i' => '\1a',
        '/sis$/i' => "ses",
        '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
        '/(hive)$/i' => '\1s',
        '/([^aeiouy]|qu)y$/i' => '\1ies',
        '/(x|ch|ss|sh)$/i' => '\1es',
        '/(matr|vert|ind)(?:ix|ex)$/i' => '\1ices',
        '/^(m|l)ouse$/i' => '\1ice',
        '/^(m|l)ice$/i' => '\1ice',
        '/^(ox)$/i' => '\1en',
        '/^(oxen)$/i' => '\1',
        '/(quiz)$/i' => '\1zes',
    ];

    private static $singulars = [
        '/s$/i' => "",
        '/(ss)$/i' => '\1',
        '/(n)ews$/i' => '\1ews',
        '/([ti])a$/i' => '\1um',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)(sis|ses)$/i' => '\1sis',
        '/(^analy)(sis|ses)$/i' => '\1sis',
        '/([^f])ves$/i' => '\1fe',
        '/(hive)s$/i' => '\1',
        '/(tive)s$/i' => '\1',
        '/([lr])ves$/i' => '\1f',
        '/([^aeiouy]|qu)ies$/i' => '\1y',
        '/(s)eries$/i' => '\1eries',
        '/(m)ovies$/i' => '\1ovie',
        '/(x|ch|ss|sh)es$/i' => '\1',
        '/^(m|l)ice$/i' => '\1ouse',
        '/(bus)(es)?$/i' => '\1',
        '/(o)es$/i' => '\1',
        '/(shoe)s$/i' => '\1',
        '/(cris|test)(is|es)$/i' => '\1is',
        '/^(a)x[ie]s$/i' => '\1xis',
        '/(octop|vir)(us|i)$/i' => '\1us',
        '/(alias|status)(es)?$/i' => '\1',
        '/^(ox)en/i' => '\1',
        '/(vert|ind)ices$/i' => '\1ex',
        '/(matr)ices$/i' => '\1ix',
        '/(quiz)zes$/i' => '\1',
        '/(database)s$/i' => '\1',
    ];

    public static function singularize(string $plural): string
    {
        if (isset(static::$uncountables[$plural])) {
            return $plural;
        }
        $irregulars = array_flip(static::$irregulars);
        foreach ($irregulars as $pattern => $replacement) {
            if (preg_match("/$pattern\$/",$plural)) {
                return preg_replace("/$pattern\$/",$replacement,$plural);
            }
        }
        foreach (array_reverse(static::$singulars, true) as $pattern => $replacement) {
            if (preg_match($pattern,$plural)) {
                return preg_replace($pattern,$replacement,$plural);
            }
        }
        return $plural;
    }

    public static function pluralize(string $singular): string
    {
        if (isset(static::$uncountables[$singular])) {
            return $singular;
        }
        foreach (static::$irregulars as $pattern => $replacement) {
            if (preg_match("/$pattern\$/",$singular)) {
                return preg_replace("/$pattern\$/",$replacement,$singular);
            }
        }
        foreach (array_reverse(static::$plurals, true) as $pattern => $replacement) {
            if (preg_match($pattern,$singular)) {
                return preg_replace($pattern,$replacement,$singular);
            }
        }
        return $singular;
    }

}