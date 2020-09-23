<?php

namespace App\HttpController\Basic;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Service\OwnerAddressService;
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

class OwnerAddress extends BaseController
{
    /**
     * 新增货主常用地址
     */
    public function insert()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            $ownerAddressService = new OwnerAddressService();
            $existIds = $ownerAddressService->getExistIds($ids);
            $ownerAddressService->insert($params, $existIds);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 修改货主常用地址
     */
    public function updateById()
    {
        try {
            $results = new Results();
            $params = $this->getRequestJsonParam();
            $ids = Utility::getIds($params);

            /** 开事物 */
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->startTransaction();

            $ownerAddressService = new OwnerAddressService();
            $existIds = $ownerAddressService->getExistIds($ids);
            $ownerAddressService->update($params, $existIds);

            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->commit();

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT)->rollback();
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }

    /**
     * 删除货主常用地址
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

            $ownerAddressService = new OwnerAddressService();
            $ownerAddressService->delete($ids);

            Web::setBody($this->response(), $results);
        } catch (\Throwable $throwable) {
            Web::failBody($this->response(), $results, $throwable->getCode(), $throwable->getMessage());
        }
    }
}
