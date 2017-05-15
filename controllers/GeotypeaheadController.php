<?php

namespace macklus\geotypeahead\controllers;

use Yii;
use yii\web\Controller;

/**
 * FichasController implements the CRUD actions for Fichas model.
 */
class GeotypeaheadController extends Controller {

    public function beforeAction($action) {
        Yii::$app->response->format = 'json';

        return parent::beforeAction($action);
    }

    public function actionPrefetch() {
        return [];
    }

    public function actionSearch() {
        $result = [];
        $q = Yii::$app->request->get('q', false);

        if ($q) {
            $query = Yii::$app->db->createCommand('SELECT gl.*, gp.name AS province, gc.name AS country FROM geo_location gl LEFT JOIN geo_country gc ON gc.id=gl.country_id LEFT JOIN geo_province gp ON gp.id=gl.province_id WHERE gl.name LIKE "%' . $q . '%"');
            foreach ($query->queryAll() as $p) {
                $result[] = [
                    'value' => html_entity_decode($p['name']) . ' (' . html_entity_decode($p['province']) . ', ' . html_entity_decode($p['country']) . ')',
                    'country_id' => $p['country_id'],
                    'province_id' => $p['province_id'],
                    'location_id' => $p['id'],
                ];
            }
        }

        return $result;
    }

}
