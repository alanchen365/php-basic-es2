<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\DepotDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class DepotService
{
    public function getExistIds(array $ids): array
    {
        $depotDao = new DepotDao();
        return $depotDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $depotDao = new DepotDao();
        $depotDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $depotDao = new DepotDao();
        $depotDao->update($params, $existIds);
    }

    public function delete(array $ids)
    {
        $depotDao = new DepotDao();
        $depotDao->delete($ids);
    }
}
