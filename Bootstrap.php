<?php

namespace macklus\geotypeahead;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app) {
        // Define route for ajax controller
        $app->getUrlManager()->addRules([
            '/geotypeaheadajax/<action:(typeaheadlocations)>' => 'geotypeaheadajax/<action>',
                ], false);
    }

}
