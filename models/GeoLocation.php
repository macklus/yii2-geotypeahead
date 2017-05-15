<?php

namespace macklus\geotypeahead\models;

use Yii;

/**
 * This is the model class for table "geo_location".
 *
 * @property int $id
 * @property int $country_id
 * @property int $province_id
 * @property string $name
 *
 * @property Partners[] $partners
 * @property Partners[] $partners0
 * @property GeoProvince $province
 * @property GeoCountry $country
 */
class GeoLocation extends \app\base\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'geo_location';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'country_id', 'province_id', 'name'], 'required'],
            [['id', 'country_id', 'province_id'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeoProvince::className(), 'targetAttribute' => ['province_id' => 'id']],
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
            'province_id' => 'Province ID',
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
        return $this->hasMany(Partners::className(), ['location_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners0() {
        return $this->hasMany(Partners::className(), ['Location' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince() {
        return $this->hasOne(GeoProvince::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(GeoCountry::className(), ['id' => 'country_id']);
    }

}
