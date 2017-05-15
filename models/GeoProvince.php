<?php

namespace macklus\geotypeahead\models;

use Yii;

/**
 * This is the model class for table "geo_province".
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 *
 * @property Partners[] $partners
 * @property GeoLocation[] $geoLocations
 * @property GeoCountry $country
 */
class GeoProvince extends \app\base\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'geo_province';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'country_id', 'name'], 'required'],
            [['id', 'country_id'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoCountry::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'name' => 'Name',
        ];
    }

    public function afterFind() {
        parent::afterFind();
        $this->name = html_entity_decode($this->name);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners() {
        return $this->hasMany(Partners::className(), ['province_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoLocations() {
        return $this->hasMany(GeoLocation::className(), ['province_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(GeoCountry::className(), ['id' => 'country_id']);
    }

}
