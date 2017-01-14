<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionTable extends AbstractMigration
{
    public function up()
    {
        $transactions = $this->table('transactions');
        $transactions->addColumn('customer_id', 'integer')
              ->addColumn('nominal', 'string', array('limit' => 255))
              ->addColumn('tanggal_transaksi', 'datetime')
              ->addColumn('type', 'boolean')
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime', array('null' => true))
              ->save();
    }

    public function down()
    {
        $this->dropTable('transactions');
    }
}
