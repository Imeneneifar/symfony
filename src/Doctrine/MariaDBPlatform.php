<?php

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\MySQL80Platform;

class MariaDBPlatform extends MySQL80Platform
{
    public function getName(): string
    {
        return 'mariadb';
    }
}
