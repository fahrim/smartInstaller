<?php

namespace Smarteknoloji\SmartInstaller\Helpers;

class RequirementsChecker
{
    /**
     * Minimum PHP,DB Version Supported (Override is in installer.php config file).
     *
     * @var $_minPhpVersion
     * @var $_minMysqlVersion
     * @var $_minMariadbVersion
     */
    private $_minPhpVersion = '7.0.0';
    private $_minMysqlVersion = '5.7.0';
    private $_minMariadbVersion = '10.3.0';

    /**
     * Check for the server requirements.
     *
     * @param array $requirements
     * @return array
     */
    public function check(array $requirements): array
    {
        $results = [];

        foreach ($requirements as $type => $requirement) {
            switch ($type) {
                // check php requirements
                case 'php':
                    foreach ($requirements[$type] as $requirement) {
                        $results['requirements'][$type][$requirement] = true;

                        if (! extension_loaded($requirement)) {
                            $results['requirements'][$type][$requirement] = false;

                            $results['errors'] = true;
                        }
                    }
                    break;
                // check php function requirements
                case 'php-function':
                    foreach ($requirements[$type] as $requirement) {
                        $results['requirements'][$type][$requirement] = true;

                        if (! function_exists($requirement)) {
                            $results['requirements'][$type][$requirement] = false;

                            $results['warnings'] = true;
                        }
                    }
                    break;
                // check apache requirements
                case 'apache':
                    foreach ($requirements[$type] as $requirement) {
                        // if function doesn't exist we can't check apache modules
                        if (function_exists('apache_get_modules')) {
                            $results['requirements'][$type][$requirement] = true;

                            if (! in_array($requirement, apache_get_modules())) {
                                $results['requirements'][$type][$requirement] = false;

                                $results['errors'] = true;
                            }
                        }
                    }
                    break;
            }
        }

        return $results;
    }

    /**
     * Check PHP version requirement.
     *
     * @param string|null $minPhpVersion
     * @return array
     */
    public function checkPhpVersion(string $minPhpVersion = null): array
    {
        $minVersionPhp = $minPhpVersion;
        $currentPhpVersion = $this->getPhpVersionInfo();
        $supported = false;

        if ($minPhpVersion == null) {
            $minVersionPhp = $this->getMinPhpVersion();
        }

        if (version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0) {
            $supported = true;
        }

        return [
            'full' => $currentPhpVersion['full'],
            'current' => $currentPhpVersion['version'],
            'minimum' => $minVersionPhp,
            'supported' => $supported,
        ];
    }

    /**
     * Get current Php version information.
     *
     * @return array
     */
    private static function getPhpVersionInfo(): array
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];

        return [
            'full' => $currentVersionFull,
            'version' => $currentVersion,
        ];
    }

    /**
     * Get minimum PHP version ID.
     *
     * @return string _minPhpVersion
     */
    protected function getMinPhpVersion(): string
    {
        return $this->_minPhpVersion;
    }


    /**
     * Check DB version requirement.
     *
     * @param array|null $currentDBVersion
     * @return array
     */
    public function checkDbVersion(array $currentDBVersion = null): array
    {
        // Step 1:: separate version for driver type
        $current = $this->getDBVersionInfo()['version'];
        if ($this->containsWord($current, 'mariaDB')) {
            $currentDBVersion = $currentDBVersion['minMariadbVersion'];
        } else {
            $currentDBVersion = $currentDBVersion['minMysqlVersion'];
        }

        // Step 2
        $minVersionDB = $currentDBVersion;
        $currentDBVersion = $this->getDBVersionInfo();
        $supported = false;

        if ($currentDBVersion == null) {
            $minVersionDB = $this->getMinDBVersion();
        }

        if (version_compare($currentDBVersion['version'], $minVersionDB) >= 0) {
            $supported = true;
        }

        return [
            'driver' => $currentDBVersion['driver'],
            'current' => $currentDBVersion['version'],
            'minimum' => $minVersionDB,
            'supported' => $supported,
        ];
    }

    /**
     * Get current DB version information.
     *
     * @return array
     */
    private static function getDBVersionInfo(): array
    {
        $dbServerVersion = \DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
        $dbDriverName = \DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        return [
            'driver' => $dbDriverName,
            'version' => $dbServerVersion,
        ];
    }

    /**
     * Get minimum DB version ID.
     *
     * @return string
     */
    protected function getMinDBVersion(): string
    {
        $current = $this->getDBVersionInfo()['version'];

        if ($this->containsWord($current, 'mariaDB')) {
            $driverVersion = $this->_minMariadbVersion;
        } else {
            $driverVersion = $this->_minMysqlVersion;
        }

        return $driverVersion;
    }

    /**
     * Search word in string.
     *
     * @param $str
     * @param $word
     * @return bool
     */
    function containsWord($str, $word): bool
    {
        return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
    }
}
