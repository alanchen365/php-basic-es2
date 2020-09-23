<?php

namespace App\Module\Basic\Service;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Dao\ProductDao;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class ProductService
{
    public function getExistIds(array $ids): array
    {
        $productDao = new ProductDao();
        return $productDao->getExistIds($ids);
    }

    public function insert(array $params, array $existIds)
    {
        $productDao = new ProductDao();
        $productDao->insert($params, $existIds);
    }

    public function update(array $params, array $existIds)
    {
        $productDao = new ProductDao();
        $productDao->update($params, $existIds);
    }
}
