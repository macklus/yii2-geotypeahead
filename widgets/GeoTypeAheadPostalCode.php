<?php
/**
 * @link 
 * @copyright 
 * @license 
 */
namespace macklus\geotypeahead\widgets;

use yii\base\Widget;
use yii\base\Model;

/**
 *
 * @author 
 */
class GeoTypeAheadPostalCode extends Widget
{

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

    /**
     * @var boolean do not generate hidden elements
     */
    public $generate_hidden_elements = false;

    /**
     * @var boolean do not generate description field
     */
    public $generate_description_element = false;

    /**
     * @var string the model attribute where we store location's description 
     */
    public $attribute_description;

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
     * @var array the allowed countries to search
     */
    public $onlyCountries = [];

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    private $_view;

    public function init()
    {
        $this->_view = $this->getView();
        return parent::init();
    }

    public function run()
    {
        parent::run();

        $pieces = explode('\\', $this->model::className());
        $formName = array_pop($pieces);
        $formNameLow = strtolower($formName);
        $widgetName = $formName . '[' . $this->attribute . ']';

        $countrySelector = "#$formNameLow-$this->attribute_country";
        $provinceSelector = "#$formNameLow-$this->attribute_province";
        $locationSelector = "#$formNameLow-$this->attribute_location";
        $descriptionSelector = "#$formNameLow-$this->attribute_description";

        $options = ['placeholder' => $this->placeholder];
        if (isSet($this->extraOptions)) {
            $options = array_merge($options, $this->extraOptions);
        }

        $html = $this->form->field($this->model, $this->attribute, (array) $this->fieldOptions)->textInput();

        if ($this->generate_hidden_elements) {
            $html .= $this->form->field($this->model, $this->attribute_country, ['template' => '{input}'])->hiddenInput()->label(false);
            $html .= $this->form->field($this->model, $this->attribute_province, ['template' => '{input}'])->hiddenInput()->label(false);
            $html .= $this->form->field($this->model, $this->attribute_location, ['template' => '{input}'])->hiddenInput()->label(false);
        }
        if ($this->generate_description_element) {
            $html .= $this->form->field($this->model, $this->attribute_description, ['template' => '{input}'])->testInput()->label(false);
        }

        $onlyCountries = (count($this->onlyCountries) > 0 ? join(',', $this->onlyCountries) : '_');

        $this->_view->registerJs("
            $('#$formNameLow-$this->attribute').blur(function(e) {
                var value = $('#$formNameLow-$this->attribute').val();
                // Beware empty postal code
                if(value == '' ) {
                    return;
                }
                var request = $.ajax({
                    url: '/geotypeahead/searchpostalcode',
                    method: 'GET',
                    data: { q: value },
                }).done(function( data ) {
                    // Beware empty or uncomplete data (i.e. you enter invalid postal code)
                    if(!data.locality || !data.province || !data.country || !data.locality_id || !data.province_id || !data.country_id) {
                        return false;
                    }
                    $('$countrySelector').val(data.country_id);
                    $('$provinceSelector').val(data.province_id);
                    $('$locationSelector').val(data.locality_id);
                    if($('$descriptionSelector').length) {
                        var message = data.locality + ' (' + data.province + ',' + data.country + ')';
                        if($('$descriptionSelector').typeahead != undefined) {
                            $('$descriptionSelector').typeahead('val', message);
                        } else {
                            $('$descriptionSelector').val(message);
                        }
                    }
                }).fail(function( jqXHR, textStatus ) {
                    console.log('fail: ' + textStatus );
                });;
            });");
        return $html;
    }
}
