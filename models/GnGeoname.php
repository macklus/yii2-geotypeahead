<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gn_geoname".
 *
 * @property integer $geonameid
 * @property string $name
 * @property string $asciiname
 * @property string $alternatenames
 * @property string $latitude
 * @property string $longitude
 * @property string $fclass
 * @property string $fcode
 * @property string $country
 * @property string $cc2
 * @property string $admin1
 * @property string $admin2
 * @property string $admin3
 * @property string $admin4
 * @property integer $population
 * @property integer $elevation
 * @property integer $gtopo30
 * @property string $timezone
 * @property string $moddate
 */
class GnGeoname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gn_geoname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['geonameid'], 'required'],
            [['geonameid', 'population', 'elevation', 'gtopo30'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['moddate'], 'safe'],
            [['name', 'asciiname'], 'string', 'max' => 200],
            [['alternatenames'], 'string', 'max' => 4000],
            [['fclass'], 'string', 'max' => 1],
            [['fcode'], 'string', 'max' => 10],
            [['country'], 'string', 'max' => 2],
            [['cc2'], 'string', 'max' => 60],
            [['admin1', 'admin3', 'admin4'], 'string', 'max' => 20],
            [['admin2'], 'string', 'max' => 80],
            [['timezone'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'geonameid' => Yii::t('geotypeahead', 'Geonameid'),
            'name' => Yii::t('geotypeahead', 'Name'),
            'asciiname' => Yii::t('geotypeahead', 'Asciiname'),
            'alternatenames' => Yii::t('geotypeahead', 'Alternatenames'),
            'latitude' => Yii::t('geotypeahead', 'Latitude'),
            'longitude' => Yii::t('geotypeahead', 'Longitude'),
            'fclass' => Yii::t('geotypeahead', 'Fclass'),
            'fcode' => Yii::t('geotypeahead', 'Fcode'),
            'country' => Yii::t('geotypeahead', 'Country'),
            'cc2' => Yii::t('geotypeahead', 'Cc2'),
            'admin1' => Yii::t('geotypeahead', 'Admin1'),
            'admin2' => Yii::t('geotypeahead', 'Admin2'),
            'admin3' => Yii::t('geotypeahead', 'Admin3'),
            'admin4' => Yii::t('geotypeahead', 'Admin4'),
            'population' => Yii::t('geotypeahead', 'Population'),
            'elevation' => Yii::t('geotypeahead', 'Elevation'),
            'gtopo30' => Yii::t('geotypeahead', 'Gtopo30'),
            'timezone' => Yii::t('geotypeahead', 'Timezone'),
            'moddate' => Yii::t('geotypeahead', 'Moddate'),
        ];
    }
}
