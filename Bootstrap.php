<?php

namespace macklus\geotypeahead;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app) {
        if ($app->hasModule('geotypeahead') && ($module = $app->getModule('geotypeahead')) instanceof Module) {
            $configUrlRule = [
                'prefix' => $module->urlPrefix,
                'rules' => $module->urlRules,
            ];

            if ($module->urlPrefix != 'geotypeahead') {
                $configUrlRule['routePrefix'] = 'geotypeahead';
            }

            $configUrlRule['class'] = 'yii\web\GroupUrlRule';
            $rule = Yii::createObject($configUrlRule);

            $app->urlManager->addRules([$rule], false);
            
        }
    }

}
