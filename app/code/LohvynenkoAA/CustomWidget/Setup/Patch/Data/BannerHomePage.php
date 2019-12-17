<?php

declare(strict_types=1);

namespace LohvynenkoAA\CustomWidget\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class BannerHomePage implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var \Magento\Cms\Model\BlockFactory $blockFactory
     */
    private $blockFactory;

    public function __construct(\Magento\Cms\Model\BlockFactory $blockFactory)
    {
        $this->blockFactory = $blockFactory;
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
        $blockData = [
            'title' => 'Banner Home page',
            'identifier' => 'geekhub-banner-home-page',
            'content' => <<<HTML
    <img src="{{media url="cms-bloks/article-marquee.jpg"}}" width="100%" alt="I think ur picture must be here -_-">
HTML,

            'stores' => [0],
            'is_active' => 1,
        ];
        $this->blockFactory->create()->setData($blockData)->save();
    }
}
