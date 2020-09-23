<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\OwnerDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class OwnerService
{
    public function getExistIds(array $ids): array
    {
        $ownerDao = new OwnerDao();
        return $ownerDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $ownerDao = new OwnerDao();
        $ownerDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $ownerDao = new OwnerDao();
        $ownerDao->update($params, $existIds);
    }
}
