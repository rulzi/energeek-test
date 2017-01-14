<?php

use Phinx\Migration\AbstractMigration;

class CreateCustomerTable extends AbstractMigration
{
    public function up()
    {
        $customers = $this->table('customers');
        $customers->addColumn('nik', 'string', array('limit' => 255))
              ->addColumn('nama', 'string', array('limit' => 255))
              ->addColumn('alamat', 'string', array('limit' => 255))
              ->addColumn('email', 'string', array('limit' => 255))
              ->addColumn('telp', 'string', array('limit' => 255))
              ->addColumn('tempat_lahir', 'string', array('limit' => 255))
              ->addColumn('tanggal_lahir', 'datetime')
              ->addColumn('foto', 'string', array('limit' => 255))
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime', array('null' => true))
              ->addIndex(array('nik', 'email'), array('unique' => true))
              ->save();
    }

    public function down()
    {
        $this->dropTable('customers');
    }
}
