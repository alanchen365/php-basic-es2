<?php

use FastRoute\RouteCollector;

return [
    '/basic' => function (RouteCollector $route) {
        // 仓库
        $route->addRoute(['POST'], '/depot', '/Basic/Depot/insert');
        $route->addRoute(['PUT'], '/depot', '/Basic/Depot/updateById');
        $route->addRoute(['DELETE'], '/depot', '/Basic/Depot/DeleteById');

        // 产品分类
        $route->addRoute(['POST'], '/producttype', '/Basic/ProductType/insert');
        $route->addRoute(['PUT'], '/producttype', '/Basic/ProductType/updateById');

        // 货主常用地址
        $route->addRoute(['POST'], '/owneraddress', '/Basic/OwnerAddress/insert');
        $route->addRoute(['PUT'], '/owneraddress', '/Basic/OwnerAddress/updateById');
        $route->addRoute(['DELETE'], '/owneraddress', '/Basic/OwnerAddress/DeleteById');

        // 货主
        $route->addRoute(['POST'], '/owner', '/Basic/Owner/insert');
        $route->addRoute(['PUT'], '/owner', '/Basic/Owner/updateById');

        // 产品
        $route->addRoute(['POST'], '/product', '/Basic/Product/insert');
        $route->addRoute(['PUT'], '/product', '/Basic/Product/updateById');
    },
];
