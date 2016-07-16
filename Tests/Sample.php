<?php

namespace Alex\DoctrineExtraBundle\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Sample
{
    public static function getEntityManager($sample)
    {
        $dir = __DIR__.'/Fixtures/'.$sample;
        $config = Setup::createAnnotationMetadataConfiguration(array($dir), true);

        $conn = array(
            'driver' => 'pdo_sqlite',
            'path' => sys_get_temp_dir().'/'.$sample.'.sqlite',
        );

        return EntityManager::create($conn, $config);
    }
}
