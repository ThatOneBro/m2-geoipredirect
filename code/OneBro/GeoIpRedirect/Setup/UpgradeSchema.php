<?php

namespace OneBro\GeoIpRedirect\Setup;


use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;


class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{
		$setup->startSetup();
		
		$setup->getConnection()->addColumn(
			$setup->getTable('store'),
			'country_code',
			[
				'type' => Table::TYPE_TEXT,
				'length' => 2,
				'nullable' => true,
				'default' => null,
				'comment' => 'Country Code'
			]
		);
		
		$setup->endSetup();
	}
	
}