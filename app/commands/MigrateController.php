<?php

namespace app\commands;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of MigrateController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var array
     */
    public $migrationLookup = [];

    /**
     * @var array
     */
    private $_migrationFiles;

    protected function getMigrationFiles()
    {
        if ($this->_migrationFiles === null) {
            $this->_migrationFiles = [];
            $directories = array_merge($this->migrationLookup, [$this->migrationPath]);
            $extraPath = ArrayHelper::getValue(Yii::$app->params, 'yii.migrations');
            if (!empty($extraPath)) {
                $directories = array_merge((array) $extraPath, $directories);
            }

            foreach (array_unique($directories) as $dir) {
                $dir = Yii::getAlias($dir, false);
                if ($dir && is_dir($dir)) {
                    $handle = opendir($dir);
                    while (($file = readdir($handle)) !== false) {
                        if ($file === '.' || $file === '..') {
                            continue;
                        }
                        $path = $dir . DIRECTORY_SEPARATOR . $file;
                        if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file($path)) {
                            $this->_migrationFiles[$matches[1]] = $path;
                        }
                    }
                    closedir($handle);
                }
            }

            ksort($this->_migrationFiles);
        }

        return $this->_migrationFiles;
    }

    protected function createMigration($class)
    {
        $file = $this->getMigrationFiles()[$class];
        require_once($file);

        return new $class(['db' => $this->db]);
    }

    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];
        foreach ($this->getMigrationFiles() as $version => $path) {
            if (!isset($applied[substr($version, 1, 13)])) {
                $migrations[] = $version;
            }
        }

        return $migrations;
    }
}
