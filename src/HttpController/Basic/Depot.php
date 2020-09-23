<?php

namespace App\HttpController\Basic;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Service\DepotService;
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

class Depot extends BaseController
{
    /**
     * 新增仓库
     */
    public function insert()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            $depotService = new DepotService();
            $existIds = $depotService->getExistIds($ids);
            $depotService->insert($params, $existIds);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 修改仓库
     */
    public function updateById()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            /** 开事物 */
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->startTransaction();

            $depotService = new DepotService();
            $existIds = $depotService->getExistIds($ids);
            $depotService->update($params, $existIds);

            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->commit();

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->rollback();
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 删除仓库
     */
    public function deleteById()
    {
        try {
            $results = new Results();

            /** 参数校验 */
            $params = $this->getRequestJsonParam();
            $ids = $params['ids'] ?? [];

            if (Tools::superEmpty($ids) || !is_array($ids)) {
                throw new AppException(1027, '参数有误');
            }

            $depotService = new DepotService();
            $depotService->delete($ids);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }
}
