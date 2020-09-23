<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\ProductTypeDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class ProductTypeService
{
    public function getExistIds(array $ids): array
    {
        $productTypeDao = new ProductTypeDao();
        return $productTypeDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $productTypeDao = new ProductTypeDao();
        $productTypeDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $productTypeDao = new ProductTypeDao();
        $productTypeDao->update($params, $existIds);
    }
}
