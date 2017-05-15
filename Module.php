<?php

/*
 * This file is part of the Macklus Yii2-Payments project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace macklus\geotypeahead;

use yii\base\Module as BaseModule;

/**
 * This is the main module class for the Yii2-payments.
 */
class Module extends BaseModule {

    const VERSION = '0.0.1';

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'geotypeahead';

    /**
     * @var bool Is the user module in DEBUG mode? Will be set to false automatically
     * if the application leaves DEBUG mode.
     */
    public $debug = false;

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        'prefetch' => 'geotypeahead/prefetch',
        'search' => 'geotypeahead/search',
    ];

}
