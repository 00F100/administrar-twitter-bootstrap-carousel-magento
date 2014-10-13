<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('carousel'))

    // ID
    ->addColumn('carousel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')

    // ID STORE
    ->addColumn('categoria_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 20, array(
        ), 'Categoria')

    //categoria_id

    // TITULO
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Titulo')

    // LINK
    ->addColumn('link', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Link')

    // IMAGEM
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Imagem')

    // ORDEM
    ->addColumn('order', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
        'nullable'  => false,
        ), 'Ordem')

    // ID STORE
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        ), 'Loja Id')

    // DESCRICAO
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        ), 'Descrição')

    // STATUS
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
        ), 'Status')

    // DATA CRIACAO
    ->addColumn('created_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Data criação')

    // DATA ATUALIZACAO
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'Data atualização');

$installer->getConnection()->createTable($table);
 
$installer->endSetup();