<?php

namespace App\HttpController\Basic;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Service\ProductTypeService;
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

class ProductType extends BaseController
{
    /**
     * 新增产品分类
     */
    public function insert()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            $productTypeService = new ProductTypeService();
            $existIds = $productTypeService->getExistIds($ids);
            $productTypeService->insert($params, $existIds);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 修改产品分类
     */
    public function updateById()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            /** 开事物 */
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->startTransaction();

            $productTypeService = new ProductTypeService();
            $existIds = $productTypeService->getExistIds($ids);
            $productTypeService->update($params, $existIds);

            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->commit();
            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->rollback();
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }
}
