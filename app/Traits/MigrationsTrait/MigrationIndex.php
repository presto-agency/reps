<?php

namespace App\Traits\MigrationsTrait;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Trait MigrationIndex
 *
 * @package Migrations
 */
trait MigrationIndex
{

    /**
     * @param $tableName
     * @param $indexName
     */
    public function _dropIndexIfExist($tableName, $indexName)
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $indexName) {
            $sm            = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails($tableName);
            if ($doctrineTable->hasIndex($indexName)) {
                $table->dropIndex($indexName);
            }
        });
    }

    /**
     * @param $tableName
     * @param $columnName
     * @param $indexName
     */
    public function _createIndexIfNotExist($tableName, $columnName, $indexName)
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $columnName, $indexName) {
            $sm            = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails($tableName);
            if ( ! $doctrineTable->hasIndex($indexName)) {
                $table->index($columnName, $indexName);
            }
        });
    }

}
