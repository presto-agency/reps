<?php


namespace App\Traits\MigrationsTrait;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Trait MigrationForeign
 *
 * @package App\Traits\MigrationsTrait
 */
trait MigrationForeign
{

    /**
     * @param $tableName
     * @param $foreignName
     */
    public function _dropForeignIfExist($tableName, $foreignName)
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $foreignName) {
            $sm            = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails($tableName);
            if ($doctrineTable->hasForeignKey($foreignName)) {
                $table->dropForeign($foreignName);
            }
        });
    }

    /**
     * @param $tableName
     * @param $foreignName
     * @param $foreignColumns
     * @param $referencesColumns
     * @param $on
     * @param $onUpdate
     * @param $onDelete
     */
    public function _createForeignIfExist($tableName, $foreignName, $foreignColumns, $referencesColumns, $on, $onUpdate, $onDelete)
    {
        Schema::table($tableName, function (Blueprint $table)
        use ($tableName, $foreignName, $foreignColumns, $referencesColumns, $on, $onUpdate, $onDelete) {
            $sm            = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails($tableName);
            if ( ! $doctrineTable->hasForeignKey($foreignName)) {

                $table->foreign($foreignColumns)
                    ->references($referencesColumns)
                    ->on($on)
                    ->onUpdate($onUpdate)
                    ->onDelete($onDelete);
            }
        });
    }

}
