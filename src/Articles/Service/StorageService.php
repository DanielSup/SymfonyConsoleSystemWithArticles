<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.9.17
 * Time: 13:55
 */

namespace Articles\Service;


class StorageService
{
    private static $instance = null;
    private $filesystem;
    private function __construct(){
        $adapter = new \League\Flysystem\Adapter\Local(__DIR__.'/var/data');
        $this->filesystem = new \League\Flysystem\Filesystem($adapter);
    }
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new StorageService();
        }
        return self::$instance;
    }

    /**
     * @return \League\Flysystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param \League\Flysystem\Filesystem $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }
}