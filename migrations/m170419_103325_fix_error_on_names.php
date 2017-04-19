<?php

use yii\db\Migration;
use macklus\geotypeahead\models\GeoCountry;
use macklus\geotypeahead\models\GeoProvince;
use macklus\geotypeahead\models\GeoLocation;

class m170419_103325_fix_error_on_names extends Migration {

    public function safeUp() {
        /*
         * Fix error on names
         * Used database has bad values on names when it uses special characters
         */
        foreach (GeoCountry::find()->where(['like', 'name', '&'])->all() as $geo) {
            preg_match_all('/(\&[\#0-9A-Za-z]*)[,;]{1}/', $geo->name, $matches);
            $geo->name = str_replace($matches[0][0], html_entity_decode($matches[1][0] . ";", ENT_QUOTES), $geo->name);
            $geo->markAttributeDirty('name');
            $geo->update(false);
        }

        foreach (GeoProvince::find()->where(['like', 'name', '&'])->all() as $province) {
            preg_match_all('/(\&[\#0-9A-Za-z]*)[,;]{1}/', $province->name, $matches);
            $province->name = str_replace($matches[0][0], html_entity_decode($matches[1][0] . ";", ENT_QUOTES), $province->name);
            $province->markAttributeDirty('name');
            $province->update();
        }

        foreach (GeoLocation::find()->where(['like', 'name', '&'])->all() as $location) {
            preg_match_all('/(\&[\#0-9A-Za-z]*)[,;]{1}/', $location->name, $matches);
            $location->name = str_replace($matches[0][0], html_entity_decode($matches[1][0] . ";", ENT_QUOTES), $location->name);
            $location->markAttributeDirty('name');
            $location->update();
        }
    }

    public function safeDown() {
        echo "m170419_093014_fix_error_on_names cannot be reverted.\n";
        return false;
    }

}
