<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * GeoTypeAheadAjaxController implements the ajax call on GeoTypeAhead plugin
 */
class GeoTypeaheadajaxController extends Controller {

    public function actionTypeaheadlocations() {
        $query = Yii::$app->request->get('query', false);
        $result = [];

        if ($query) {
            $query = Yii::$app->db->createCommand('SELECT gl.*, gp.name AS province, gc.name AS country FROM geo_location gl LEFT JOIN geo_country gc ON gc.id=gl.country_id LEFT JOIN geo_province gp ON gp.id=gl.province_id WHERE gl.name LIKE "%' . $query . '%"');
            foreach ($query->queryAll() as $p) {
                $result[] = [
                    'name' => html_entity_decode($p['name']) . ', ' . html_entity_decode($p['province']) . ', ' . html_entity_decode($p['country']),
                    'country_id' => $p['country_id'],
                    'province_id' => $p['province_id'],
                    'location_id' => $p['id'],
                ];
            }
        }

        \Yii::$app->response->format = 'json';
        return $result;
    }

}
