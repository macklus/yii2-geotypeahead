<?php

use yii\db\Migration;

class m170419_103316_add_geo_tables extends Migration
{

    public function safeUp()
    {
        $this->createTable('geo_country', [
            'id' => 'smallint(6) NOT NULL',
            'name' => 'varchar(150) CHARACTER SET latin1 NOT NULL',
                ], ' ENGINE=InnoDB DEFAULT CHARSET=utf8 ');
        $this->addPrimaryKey('primary_key', 'geo_country', 'id');

        $this->createTable('geo_province', [
            'id' => 'smallint(6) NOT NULL',
            'country_id' => 'smallint(6) NOT NULL',
            'name' => 'varchar(150) CHARACTER SET latin1 NOT NULL',
                ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addPrimaryKey('primary_key', 'geo_province', 'id');
        $this->createIndex('INDEX_country', 'geo_province', 'country_id');
        $this->addForeignKey('FK_province_country', 'geo_province', 'country_id', 'geo_country', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('geo_location', [
            'id' => 'mediumint(9) NOT NULL',
            'country_id' => 'smallint(6) NOT NULL',
            'province_id' => 'smallint(6) NOT NULL',
            'name' => 'varchar(150) CHARACTER SET latin1 NOT NULL',
                ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addPrimaryKey('primary_key', 'geo_location', 'id');
        $this->createIndex('INDEX_country', 'geo_location', 'country_id');
        $this->createIndex('INDEX_province', 'geo_location', 'province_id');
        $this->addForeignKey('FK_location_country', 'geo_location', 'country_id', 'geo_country', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_location_province', 'geo_location', 'province_id', 'geo_province', 'id', 'CASCADE', 'CASCADE');

        // Get data to insert
        $sqlDir = Yii::getAlias('@vendor/macklus/yii2-geoselect/data');
        $sqlInsert1 = file_get_contents($sqlDir . '/geo_country.sql');
        $this->execute($sqlInsert1);
        $sqlInsert2 = file_get_contents($sqlDir . '/geo_province.sql');
        $this->execute($sqlInsert2);
        $sqlInsert3 = file_get_contents($sqlDir . '/geo_location.sql');
        $this->execute($sqlInsert3);
    }

    public function safeDown()
    {
        $this->dropTable('geo_location');
        $this->dropTable('geo_province');
        $this->dropTable('geo_country');
    }
    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
