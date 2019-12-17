<?php

declare(strict_types=1);

namespace LohvynenkoAA\CustomWidget\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class ProductList implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory $pageFactory
     */
    private $pageFactory;

    /**
     * AddNewCmsPage constructor.
     * @param PageFactory $pageFactory
     * @param $moduleDataSetup
     */
    public function __construct(
        PageFactory $pageFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getVersion()
    {
        return '2.3.3';
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $pageData = [
            'title' => 'Product List',
            'page_layout' => '1column',
            'meta_keywords' => 'Page keywords',
            'meta_description' => 'Page description',
            'identifier' => 'geekhub-cms',
            'content_heading' => '',
            'content' => <<<HTML
    {{widget type="Magento\CatalogWidget\Block\Product\ProductsList" show_pager="0" products_count="5" 
    template="Magento_CatalogWidget::product/widget/content/grid.phtml" 
    conditions_encoded="^[`1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Combine`,
    `aggregator`:`all`,`value`:`1`,`new_child`:``^],`1--1`:^[`type`:`Magento||CatalogWidget||Model||Rule||Condition||Product`,
    `attribute`:`category_ids`,`operator`:`==`,`value`:`23`^]^]"}}
HTML,
            'layout_update_xml' => '',
            'url_key' => 'geekhub-cms',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];

        $this->moduleDataSetup->startSetup();
        $this->pageFactory->create()->setData($pageData)->save();
        $this->moduleDataSetup->endSetup();
    }
}
