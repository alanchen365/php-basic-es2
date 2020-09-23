<?php

namespace App\Module\Basic\Dao;

use App\Module\Basic\Consts\BasicConst;
use App\Module\Basic\Utility;
use AsaEs\AsaEsConst;
use AsaEs\Config;
use AsaEs\Exception\AppException;
use AsaEs\Utility\ArrayUtility;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;

class ProductTypeDao
{
    public function getExistIds(array $ids): array
    {
        /** @var \MysqliDb $db */
        $db = Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT);
        $existList = $db->where('id', $ids, 'IN')->get(BasicConst::TABLE_PRODUCT_TYPE, null, 'id');
        return array_column($existList, 'id');
    }

    public function insert(array $params, array $existIds)
    {
        /** @var \MysqliDb $db */
        $db = Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT);

        foreach ($params as $key => $param) {
            $id = $param['id'] ?? null;
            Utility::idIsExist($id);

            /** 已存在的数据过滤掉 */
            if (!ArrayUtility::arrayFlip($existIds, $id)) {
                $flg = $db->insert(BasicConst::TABLE_PRODUCT_TYPE, $param);
                if (!$flg) {
                    throw new AppException(1027, $db->getLastError());
                }

                $env = Config::getInstance()->getEnv();
                if ($env != 'PRODUCTION') {
                    echo $db->getLastQuery() . "\n";
                }

                Logger::getInstance()->log($db->getLastQuery(), 'AsalProductType');
            }
        }
    }

    public function update(array $params, array $existIds)
    {
        /** @var \MysqliDb $db */
        $db = Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT);

        foreach ($params as $key => $param) {
            $id = $param['id'] ?? null;
            Utility::idIsExist($id);

            /** 如果不存在 就报错 */
            if (!ArrayUtility::arrayFlip($existIds, $id)) {
                throw new AppException(1028, "id $id 不存在 无法进行修改");
            }

            // 去掉主键
            unset($param['id'], $param['code']);

            $flg = $db->where('id', $id)->update(BasicConst::TABLE_PRODUCT_TYPE, $param);
            if (!$flg) {
                throw new AppException(1027, $db->getLastError());
            }

            $env = Config::getInstance()->getEnv();
            if ($env != 'PRODUCTION') {
                echo $db->getLastQuery() . "\n";
            }

            Logger::getInstance()->log($db->getLastQuery(), 'AsalProductType');
        }
    }
}
