<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\OwnerAddressDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class OwnerAddressService
{
    public function getExistIds(array $ids): array
    {
        $ownerAddressDao = new OwnerAddressDao();
        return $ownerAddressDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $ownerAddressDao = new OwnerAddressDao();
        $ownerAddressDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $ownerAddressDao = new OwnerAddressDao();
        $ownerAddressDao->update($params, $existIds);
    }

    public function delete(array $ids)
    {
        $ownerAddressDao = new OwnerAddressDao();
        $ownerAddressDao->delete($ids);
    }
}
