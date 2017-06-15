<?php

/**
 * @link
 * @copyright
 * @license
 */

namespace macklus\geotypeahead\widgets;

use Yii;
use yii\base\Widget;
use yii\base\Model;
use kartik\widgets\Typeahead;
use yii\helpers\Url;

/**
 *
 * @author
 * @since
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
     * @var string the model attribute where we store country_id.
     */
    public $attribute_country;

    /**
     * @var string the model attribute where we store province_id.
     */
    public $attribute_province;

    /**
     * @var string the model attribute where we store location_id.
     */
    public $attribute_location;

    /**
     * @var string the placeholder who appears on search input
     */
    public $placeholder;

    /**
     * @var array options to add on typeahead
     */
    public $extraOptions;

    /**
     * @var array options to add on form element
     */
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
