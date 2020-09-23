<?php

namespace App\HttpController\Basic;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Service\OwnerService;
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

class Owner extends BaseController
{
    /**
     * 新增货主
     */
    public function insert()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            $ownerService = new OwnerService();
            $existIds = $ownerService->getExistIds($ids);
            $ownerService->insert($params, $existIds);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 修改货主
     */
    public function updateById()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            /** 开事物 */
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->startTransaction();

            $ownerService = new OwnerService();
            $existIds = $ownerService->getExistIds($ids);
            $ownerService->update($params, $existIds);

            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->commit();
            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->rollback();
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }
}
