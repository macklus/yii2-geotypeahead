<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace macklus\geotypeahead\widgets;

use Yii;
use yii\base\Widget;
use yii\base\Model;
use kartik\widgets\Typeahead;
use yii\helpers\Url;

/**
 * InputWidget is the base class for widgets that collect user inputs.
 *
 * An input widget can be associated with a data model and an attribute,
 * or a name and a value. If the former, the name and the value will
 * be generated automatically.
 *
 * Classes extending from this widget can be used in an [[\yii\widgets\ActiveForm|ActiveForm]]
 * using the [[\yii\widgets\ActiveField::widget()|widget()]] method, for example like this:
 *
 * ```php
 * <?= $form->field($model, 'from_date')->widget('WidgetClassName', [
 *     // configure additional widget properties here
 * ]) ?>
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GeoTypeAhead extends Widget {

    /**
     * 
     */
    public $form;

    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;
    public $attribute_country;
    public $attribute_province;
    public $attribute_location;
    public $placeholder;
    public $extraOptions;
    public $fieldOptions;

    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;

    /**
     * @var string the input value.
     */
    public $value;

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    private $_view;

    public function init() {
        $this->_view = $this->getView();
        return parent::init();
    }

    public function run() {
        parent::run();

        $pieces = explode('\\', $this->model::className());
        $formName = array_pop($pieces);
        $formNameLow = strtolower($formName);
        $widgetName = $formName . '[' . $this->attribute . ']';

        $countrySelector = "#$formNameLow-$this->attribute_country";
        $provinceSelector = "#$formNameLow-$this->attribute_province";
        $locationSelector = "#$formNameLow-$this->attribute_location";

        $options = ['placeholder' => $this->placeholder];
        if (isSet($this->extraOptions)) {
            $options = array_merge($options, $this->extraOptions);
        }

        $html = $this->form->field($this->model, $this->attribute, (array) $this->fieldOptions)->widget(Typeahead::classname(), [
            'name' => $widgetName,
            'value' => $this->model->{$this->attribute},
            'options' => $options,
            'pluginOptions' => ['highlight' => true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'prefetch' => '/geotypeahead/prefetch',
                    'limit' => 50,
                    'remote' => [
                        'url' => Url::to(['geotypeahead/search']) . '?q=%QUERY',
                        'wildcard' => '%QUERY',
                    ]
                ]
            ],
            'pluginEvents' => [
                "typeahead:select" => "function(event, data) {"
                . "$('$countrySelector').val(data.country_id);"
                . "$('$provinceSelector').val(data.province_id);"
                . "$('$locationSelector').val(data.location_id);"
                . "$('$countrySelector').val(data.country_id).trigger('change');"
                . "$('$provinceSelector').val(data.province_id).trigger('change');"
                . "$('$locationSelector').val(data.location_id).trigger('change');"
                . "}",
            ]
        ]);

        $html .= $this->form->field($this->model, $this->attribute_country, ['template' => '{input}'])->hiddenInput()->label(false);
        $html .= $this->form->field($this->model, $this->attribute_province, ['template' => '{input}'])->hiddenInput()->label(false);
        $html .= $this->form->field($this->model, $this->attribute_location, ['template' => '{input}'])->hiddenInput()->label(false);

        return $html;
    }

}
