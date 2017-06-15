<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gn_admin2Codes".
 *
 * @property string $code
 * @property string $name
 * @property string $nameAscii
 * @property integer $geonameid
 */
class GnAdmin2Codes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gn_admin2Codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'nameAscii'], 'string'],
            [['geonameid'], 'integer'],
            [['code'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('geotypeahead', 'Code'),
            'name' => Yii::t('geotypeahead', 'Name'),
            'nameAscii' => Yii::t('geotypeahead', 'Name Ascii'),
            'geonameid' => Yii::t('geotypeahead', 'Geonameid'),
        ];
    }
}
