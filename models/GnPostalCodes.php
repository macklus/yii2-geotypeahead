<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gn_postalCodes".
 *
 * @property string $country
 * @property string $postal_code
 * @property string $name
 * @property string $admin1_name
 * @property string $admin1_code
 * @property string $admin2_name
 * @property string $admin2_code
 * @property string $admin3_name
 * @property string $admin3_code
 * @property string $latitude
 * @property string $longitude
 * @property integer $accuracy
 */
class GnPostalCodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gn_postalCodes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['accuracy'], 'integer'],
            [['country'], 'string', 'max' => 2],
            [['postal_code', 'admin1_code', 'admin2_code', 'admin3_code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 180],
            [['admin1_name', 'admin2_name', 'admin3_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country' => Yii::t('geotypeahead', 'Country'),
            'postal_code' => Yii::t('geotypeahead', 'Postal Code'),
            'name' => Yii::t('geotypeahead', 'Name'),
            'admin1_name' => Yii::t('geotypeahead', 'Admin1 Name'),
            'admin1_code' => Yii::t('geotypeahead', 'Admin1 Code'),
            'admin2_name' => Yii::t('geotypeahead', 'Admin2 Name'),
            'admin2_code' => Yii::t('geotypeahead', 'Admin2 Code'),
            'admin3_name' => Yii::t('geotypeahead', 'Admin3 Name'),
            'admin3_code' => Yii::t('geotypeahead', 'Admin3 Code'),
            'latitude' => Yii::t('geotypeahead', 'Latitude'),
            'longitude' => Yii::t('geotypeahead', 'Longitude'),
            'accuracy' => Yii::t('geotypeahead', 'Accuracy'),
        ];
    }
}
