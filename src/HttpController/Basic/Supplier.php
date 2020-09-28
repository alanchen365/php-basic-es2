<?php

namespace App\HttpController\Basic;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Service\SupplierService;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Base\BaseController;
use AsaEs\Exception\AppException;
use AsaEs\Output\Results;
use AsaEs\Output\Web;
use AsaEs\Utility\ArrayUtility;
use AsaEs\Utility\Tools;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class Supplier extends BaseController
{
    /**
     * 新增供应商
     */
    public function insert()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            $supplierService = new SupplierService();
            $existIds = $supplierService->getExistIds($ids);
            $supplierService->insert($params, $existIds);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 修改供应商
     */
    public function updateById()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            /** 开事物 */
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->startTransaction();

            $supplierService = new SupplierService();
            $existIds = $supplierService->getExistIds($ids);
            $supplierService->update($params, $existIds);

            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->commit();

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->rollback();
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }
}
