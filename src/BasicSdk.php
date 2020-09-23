<?php

namespace Basic;

use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Core\Utility\File;

class BasicSdk
{
    use Singleton;

    public function run()
    {
        /** 先删除 */
        $targetController = EASYSWOOLE_ROOT . '/App/HttpController/Basic/';
        File::deleteDir($targetController);

        $targetModule = EASYSWOOLE_ROOT . '/App/Module/Basic/';
        File::deleteDir($targetModule);

        /** 后复制 */
        $sdkController = EASYSWOOLE_ROOT . '/vendor/alanchen365/basic-sdk-es2/src/HttpController/Basic/';
        File::copyDir($sdkController, $targetController);

        $sdkModule = EASYSWOOLE_ROOT . '/vendor/alanchen365/basic-sdk-es2/src/Module/Basic/';
        File::copyDir($sdkModule, $targetModule);
    }
}
