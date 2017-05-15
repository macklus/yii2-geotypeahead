<?php

namespace macklus\geotypeahead\models;

use Yii;

/**
 * This is the model class for table "geo_country".
 *
 * @property int $id
 * @property string $name
 *
 * @property Partners[] $partners
 * @property GeoLocation[] $geoLocations
 * @property GeoProvince[] $geoProvinces
 */
class GeoCountry extends \app\base\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'geo_country';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
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
        return $this->hasMany(Partners::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoLocations() {
        return $this->hasMany(GeoLocation::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeoProvinces() {
        return $this->hasMany(GeoProvince::className(), ['country_id' => 'id']);
    }

}
