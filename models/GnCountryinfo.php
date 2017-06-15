<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gn_countryinfo".
 *
 * @property string $iso_alpha2
 * @property string $iso_alpha3
 * @property integer $iso_numeric
 * @property string $fips_code
 * @property string $name
 * @property string $capital
 * @property double $areainsqkm
 * @property integer $population
 * @property string $continent
 * @property string $tld
 * @property string $currency
 * @property string $currencyName
 * @property string $Phone
 * @property string $postalCodeFormat
 * @property string $postalCodeRegex
 * @property integer $geonameId
 * @property string $languages
 * @property string $neighbours
 * @property string $equivalentFipsCode
 */
class GnCountryinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gn_countryinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iso_numeric', 'population', 'geonameId'], 'integer'],
            [['areainsqkm'], 'number'],
            [['iso_alpha2', 'continent'], 'string', 'max' => 2],
            [['iso_alpha3', 'fips_code', 'tld', 'currency'], 'string', 'max' => 3],
            [['name', 'capital', 'languages'], 'string', 'max' => 200],
            [['currencyName'], 'string', 'max' => 20],
            [['Phone', 'equivalentFipsCode'], 'string', 'max' => 10],
            [['postalCodeFormat', 'neighbours'], 'string', 'max' => 100],
            [['postalCodeRegex'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iso_alpha2' => Yii::t('geotypeahead', 'Iso Alpha2'),
            'iso_alpha3' => Yii::t('geotypeahead', 'Iso Alpha3'),
            'iso_numeric' => Yii::t('geotypeahead', 'Iso Numeric'),
            'fips_code' => Yii::t('geotypeahead', 'Fips Code'),
            'name' => Yii::t('geotypeahead', 'Name'),
            'capital' => Yii::t('geotypeahead', 'Capital'),
            'areainsqkm' => Yii::t('geotypeahead', 'Areainsqkm'),
            'population' => Yii::t('geotypeahead', 'Population'),
            'continent' => Yii::t('geotypeahead', 'Continent'),
            'tld' => Yii::t('geotypeahead', 'Tld'),
            'currency' => Yii::t('geotypeahead', 'Currency'),
            'currencyName' => Yii::t('geotypeahead', 'Currency Name'),
            'Phone' => Yii::t('geotypeahead', 'Phone'),
            'postalCodeFormat' => Yii::t('geotypeahead', 'Postal Code Format'),
            'postalCodeRegex' => Yii::t('geotypeahead', 'Postal Code Regex'),
            'geonameId' => Yii::t('geotypeahead', 'Geoname ID'),
            'languages' => Yii::t('geotypeahead', 'Languages'),
            'neighbours' => Yii::t('geotypeahead', 'Neighbours'),
            'equivalentFipsCode' => Yii::t('geotypeahead', 'Equivalent Fips Code'),
        ];
    }
}
