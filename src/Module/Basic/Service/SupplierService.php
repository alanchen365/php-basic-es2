<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\SupplierDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class SupplierService
{
    public function getExistIds(array $ids): array
    {
        $supplierDao = new SupplierDao();
        return $supplierDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $supplierDao = new SupplierDao();
        $supplierDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $supplierDao = new SupplierDao();
        $supplierDao->update($params, $existIds);
    }
}
