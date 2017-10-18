<?php
namespace macklus\geotypeahead\controllers;

use Yii;
use yii\web\Controller;
use macklus\geotypeahead\traits\DataTrait;

/**
 * FichasController implements the CRUD actions for Fichas model.
 */
class GeotypeaheadController extends Controller
{

    private $_countries = 'ES,FR,UK,AD,PT';

    public function beforeAction($action)
    {
        Yii::$app->response->format = 'json';

        return parent::beforeAction($action);
    }

    public function actionPrefetch()
    {
        return [];
    }

    public function actionSearch()
    {
        $result = [];
        $q = Yii::$app->request->get('q', false);
        $co = Yii::$app->request->get('oc', $this->_countries);

        // Ensure 2 letters code
        $countries = '';
        foreach (explode(',', $co) as $c) {
            $countries .= "'" . strtoupper(substr($c, 0, 2)) . "',";
        }
        $countries = substr($countries, 0, -1);

        if ($q) {
            $query = Yii::$app->db->createCommand('SELECT gn_geoname.geonameid AS locality_id, gn_geoname.name AS locality, gn_admin2Codes.geonameid AS province_id, gn_admin2Codes.name AS province, gn_countryinfo.geonameid AS country_id, gn_countryinfo.name AS country FROM gn_geoname LEFT JOIN gn_admin2Codes ON CONCAT(gn_geoname.country, ".", gn_geoname.admin1, ".", gn_geoname.admin2) = gn_admin2Codes.code LEFT JOIN gn_countryinfo ON gn_geoname.country = gn_countryinfo.iso_alpha2 WHERE gn_countryinfo.iso_alpha2 in (' . $countries . ') AND gn_geoname.name LIKE :query AND gn_geoname.fcode LIKE "PPL%" ORDER BY gn_geoname.population DESC;');
            $my_search = "%{$q}%";
            $query->bindParam(":query", $my_search, \PDO::PARAM_STR);
            foreach ($query->queryAll() as $p) {
                $result[] = [
                    'value' => html_entity_decode($p['locality']) . ' (' . html_entity_decode($p['province']) . ', ' . html_entity_decode($p['country']) . ')',
                    'country_id' => $p['country_id'],
                    'province_id' => $p['province_id'],
                    'location_id' => $p['locality_id'],
                ];
            }
        }
        return $result;
    }

    public function actionSearchpostalcode()
    {
        $result = [];
        $q = Yii::$app->request->get('q', false);

        if ($q) {
            /*
             * SELECT gn_postalCodes.postal_code AS zip, gn_postalCodes.name AS locality FROM gn_postalCodes WHERE postal_code LIKE "%42004%" AND gn_postalCodes.country IN ("ES", "FR", "UK", "AD", "PT") ORDER BY FIELD(gn_postalCodes.country, "ES", "FR", "UK", "AD", "PT") LIMIT 1;             
             */
            $query = Yii::$app->db->createCommand('select gn_postalCodes.postal_code as zip, gn_postalCodes.name as locality from gn_postalCodes where postal_code = :postalcode and gn_postalCodes.country IN ("ES", "FR", "UK", "AD", "PT") order by FIELD(gn_postalCodes.country, "ES", "FR", "UK", "AD", "PT")  LIMIT 1');
            $query->bindParam(':postalcode', $q, \PDO::PARAM_STR);
            $tmpdata = $query->queryOne();

            if (isset($tmpdata["locality"])) {
                $query2 = Yii::$app->db->createCommand('select gn_geoname.geonameid as locality_id, gn_geoname.name as locality, gn_admin2Codes.geonameid as province_id, gn_admin2Codes.name as province, gn_countryinfo.geonameid as country_id, gn_countryinfo.name as country from gn_geoname left join gn_admin2Codes on CONCAT(gn_geoname.country, ".", gn_geoname.admin1, ".", gn_geoname.admin2) = gn_admin2Codes.code left join gn_countryinfo on gn_geoname.country = gn_countryinfo.iso_alpha2 where gn_geoname.name like :locality and gn_geoname.fcode like "PPL%" order by gn_geoname.population desc limit 1');
                $query2->bindParam(':locality', $tmpdata["locality"], \PDO::PARAM_STR);
                return $query2->queryOne();
            }
        }
        return [];
    }
}
