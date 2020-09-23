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

class ProductDao
{
    public function getExistIds(array $ids): array
    {
        /** @var \MysqliDb $db */
        $db = Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT);
        $existList = $db->where('id', $ids, 'IN')->get(BasicConst::TABLE_PRODUCT, null, 'id');
        return array_column($existList, 'id');
    }

    public function insert(array $params, array $existIds)
    {
        /** @var \MysqliDb $db */
        $db = Di::getInstance()->get(AsaEsConst::DI_MYSQL_DEFAULT);

        foreach ($params as $key => $param) {
            $id = $param['id'] ?? null;
            Utility::idIsExist($id);

            $productUnit = $param['product_unit'] ?? [];
            $productToType = $param['product_to_type'] ?? [];
            $productSupplier = $param['product_supplier'] ?? [];
            unset($param['product_unit'], $param['product_to_type'], $param['product_supplier']);

            /** 已存在的数据过滤掉 */
            if (!ArrayUtility::arrayFlip($existIds, $id)) {
                $flg = $db->insert(BasicConst::TABLE_PRODUCT, $param);
                if (!$flg) {
                    throw new AppException(1027, $db->getLastError());
                } else {
                    foreach ($productUnit as $k => $one) {
                        $productUnitFlg = $db->insert(BasicConst::TABLE_PRODUCT_UNIT, $one);
                        if (!$productUnitFlg) {
                            throw new AppException(1027, $db->getLastError());
                        }
                    }

                    if (!empty($productToType)) {
                        foreach ($productToType as $k => $one) {
                            $productToTypeFlg = $db->insert(BasicConst::TABLE_PRODUCT_TO_TYPE, $one);
                            if (!$productToTypeFlg) {
                                throw new AppException(1027, $db->getLastError());
                            }
                        }
                    }

                    if (!empty($productSupplier)) {
                        foreach ($productSupplier as $k => $one) {
                            $productSupplierFlg = $db->insert(BasicConst::TABLE_PRODUCT_SUPPLIER, $one);
                            if (!$productSupplierFlg) {
                                throw new AppException(1027, $db->getLastError());
                            }
                        }
                    }
                }

                $env = Config::getInstance()->getEnv();
                if ($env != 'PRODUCTION') {
                    echo $db->getLastQuery() . "\n";
                }

                Logger::getInstance()->log($db->getLastQuery(), 'AsalProduct');
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

            $productUnit = $param['product_unit'] ?? [];
            $productToType = $param['product_to_type'] ?? [];
            $productSupplier = $param['product_supplier'] ?? [];
            unset($param['product_unit'], $param['product_to_type'], $param['product_supplier']);

            /** 如果不存在 就报错 */
            if (!ArrayUtility::arrayFlip($existIds, $id)) {
                throw new AppException(1028, "id $id 不存在 无法进行修改");
            }

            // 去掉主键
            unset($param['id'], $param['code']);

            $flg = $db->where('id', $id)->update(BasicConst::TABLE_PRODUCT, $param);
            if (!$flg) {
                throw new AppException(1027, $db->getLastError());
            } else {
                $deleteFlg = $db->where('product_code', $id)->delete(BasicConst::TABLE_PRODUCT_UNIT);
                if (!$deleteFlg) {
                    throw new AppException(1027, $db->getLastError());
                } else {
                    foreach ($productUnit as $k => $one) {
                        $productUnitFlg = $db->insert(BasicConst::TABLE_PRODUCT_UNIT, $one);
                        if (!$productUnitFlg) {
                            throw new AppException(1027, $db->getLastError());
                        }
                    }
                }

                $db->where('product_code', $id)->delete(BasicConst::TABLE_PRODUCT_TO_TYPE);
                if (!empty($productToType)) {
                    foreach ($productToType as $k => $one) {
                        $productToTypeFlg = $db->insert(BasicConst::TABLE_PRODUCT_TO_TYPE, $one);
                        if (!$productToTypeFlg) {
                            throw new AppException(1027, $db->getLastError());
                        }
                    }
                }

                $db->where('product_code', $id)->delete(BasicConst::TABLE_PRODUCT_SUPPLIER);
                if (!empty($productSupplier)) {
                    foreach ($productSupplier as $k => $one) {
                        $productSupplierFlg = $db->insert(BasicConst::TABLE_PRODUCT_SUPPLIER, $one);
                        if (!$productSupplierFlg) {
                            throw new AppException(1027, $db->getLastError());
                        }
                    }
                }
            }

            $env = Config::getInstance()->getEnv();
            if ($env != 'PRODUCTION') {
                echo $db->getLastQuery() . "\n";
            }

            Logger::getInstance()->log($db->getLastQuery(), 'AsalProduct');
        }
    }
}
