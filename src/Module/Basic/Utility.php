<?php

namespace App\Module\Basic;

use AsaEs\Exception\AppException;
use AsaEs\Utility\Tools;

class Utility
{
    public static function getIds(array $params): array
    {
        $ids = array_column($params, 'id');
        if (Tools::superEmpty($ids)) {
            throw new AppException(1022, '参数有误');
        }

        return $ids;
    }

    public static function idIsExist($id = null)
    {
        if (Tools::superEmpty($id)) {
            throw new AppException(1023, '参数有误');
        }
    }
}
