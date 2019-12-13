<?php
/**
 * Copyright © 2018 . All rights reserved.
 */

namespace Ced\PwaApi\Setup;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        \Ced\PwaApi\Model\PwaSliderFactory $pwaSliderFactory,
        \Magento\Cms\Model\BlockFactory $blockFactory
    ) {
        $this->pwaSliderFactory = $pwaSliderFactory;
        $this->blockFactory = $blockFactory;
    }

     public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            'slider_name' => 'Home Slider',
            'content' => 'pwa-theme/slider/hs1_optimized.jpg,pwa-theme/slider/hs2_optimized.jpg,pwa-theme/slider/hs3_optimized.jpg',
            'code' => 'homeslide',
            'type' => 'slider'
        ];
        $slider = $this->pwaSliderFactory->create()->load('homeslide','code');
        if(!$slider->getId()){
            $this->pwaSliderFactory->create()->setData($data)->save();
        }

        $categoryIcons = $this->blockFactory->create();
            $categoryIcons->load('category_icons', 'identifier');
            // phpcs:disable Magento2.Files.LineLength.MaxExceeded
            if (!$categoryIcons->getId()) {
                $categoryIconsData = [
                    'title' => 'Category Icons',
                    'identifier' => 'category_icons',
                    'content' => '<div class="line-icon-section">
                                    <div class="container">
                                    <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="icon-wrapper">
                                    <ul>
                                    <li class="icon-list"><a href="/women/tops-women/tees-women.html"> <img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/tees.png&quot;}}" alt="tees icon" width="50" height="50"> Tees </a></li>
                                    <li class="icon-list"><a href="/gear/bags.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/bag.png&quot;}}" alt="bag icon" width="50" height="50">Bag</a></li>
                                    <li class="icon-list"><a href="/women/tops-women/jackets-women.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/jacket.png&quot;}}" alt="jacket icon" width="50" height="50">Jacket</a></li>
                                    <li class="icon-list"><a href="/women/bottoms-women/shorts-women.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/shorts.png&quot;}}" alt="shorts icon" width="50" height="50">Shorts</a></li>
                                    <li class="icon-list"><a href="/gear/fitness-equipment.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/fitnees.png&quot;}}" alt="fitness icon" width="50" height="50">Fitness Equipment</a></li>
                                    <li class="icon-list"><a href="/women/bottoms-women/pants-women.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/pants.png&quot;}}" alt="pants icon" width="50" height="50">Pants</a></li>
                                    <li class="icon-list"><a href="/gear/watches.html"><img class="svg-icon" src="{{media url=&quot;pwa-theme/banners/category/watch.png&quot;}}" alt="watch icon" width="50" height="50">Watch</a></li>
                                    </ul>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>',
                    'stores' => 0,
                    'is_active' => 1,
                ];
                $this->blockFactory->create()->setData($categoryIconsData)->save();
            }

            $categoryBanner = $this->blockFactory->create();
            $categoryBanner->load('category_banner', 'identifier');
            if (!$categoryBanner->getId()) {
                $categoryBannerData = [
                    'title' => 'Category Banner',
                    'identifier' => 'category_banner',
                    'content' => '<div class="category-images-block">
                                    <div class="container">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                    <div class="top-left">
                                    <div class="left-image-wrapper"><a href="/men.html"> <img class="left-category-image m-0 img-fluid" src="{{media url=&quot;pwa-theme/banners/banner1.jpg&quot;}}" alt="block" width="570" height="442"> </a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/men.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                    <div class="top-right">
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <div class="right-banner">
                                    <div><a href="/women.html"><img class="right-category-image m-0 img-fluid" src="{{media url=&quot;pwa-theme/banners/banner2.jpg&quot;}}" alt="block" width="270" height="270"></a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/women.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 top_right">
                                    <div class="right-banner">
                                    <div><a href="/gear/bags.html"><img class="right-category-image m-0 img-fluid" src="{{media url=&quot;pwa-theme/banners/banner3.jpeg&quot;}}" alt="block" width="270" height="270"></a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/gear/bags.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="right-banner">
                                    <div><a href="/gear/watches.html"><img class="right-category-image m-0 img-fluid" src="{{media url=&quot;pwa-theme/banners/banner4.jpg&quot;}}" alt="block" width="570" height="210"></a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/gear/watches.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>',
                    'stores' => 0,
                    'is_active' => 1,
                ];
                $this->blockFactory->create()->setData($categoryBannerData)->save();
            }


            $offerBanner = $this->blockFactory->create();
            $offerBanner->load('offer_banner', 'identifier');
            if (!$offerBanner->getId()) {
                $offerBannerData = [
                    'title' => 'Offer Banner',
                    'identifier' => 'offer_banner',
                    'content' => '<div class="container">
                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                    <div class="lower-banner">
                                    <div><a href="/gear/fitness-equipment.html"><img class="img-fluid m-0" src="{{media url=&quot;pwa-theme/banners/banner_image2.jpg&quot;}}" alt="block" width="500" height="300"></a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/women.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                    <div class="lower-banner">
                                    <div><a href="/gear/watches.html"><img class="img-fluid m-0" src="{{media url=&quot;pwa-theme/banners/banner_image1.jpg&quot;}}" alt="block" width="500" height="300"></a></div>
                                    <div class="banner-overlay">
                                    <div class="banner-overlay-content">
                                    <div class="inner">
                                    <h5>Shoes are now available</h5>
                                    <a href="/women.html">View more</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>',
                    'stores' => 0,
                    'is_active' => 1,
                ];
                $this->blockFactory->create()->setData($offerBannerData)->save();
            }

            $footerBlock = $this->blockFactory->create();
            $footerBlock->load('ced-pwa-footer', 'identifier');
            if (!$footerBlock->getId()) {
                $footerBlockData = [
                    'title' => 'Ced Pwa Footer',
                    'identifier' => 'ced-pwa-footer',
                    'content' => '<div class="footer_area">
                                    <div class="container">
                                    <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="single_footer_widget">
                                    <div class="footer_logo">
                                    <div class="image-wrapper"><img class="img-fluid" title="Venia" src="{{media url=&quot;pwa-theme/144x144.png&quot;}}" alt="Ced Pwa" width="48" height="24"></div>
                                    </div>
                                    <div class="our_info">
                                    <p>Over 24 years experience &amp; knowledge international standards, technologicaly changes &amp; industrial systems, we are dedicated to provides seds the best &amp; solutions to our valued customers.</p>
                                    <div class="button_new"><a href="/">Read More</a></div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
                                    <div class="single_footer_widget">
                                    <div class="title">
                                    <h3>Useful Links</h3>
                                    </div>
                                    <ul class="usefull_links">
                                    <li><a href="/about-Us">About Us</a></li>
                                    <li><a href="/">Our Services</a></li>
                                    <li><a href="/">Latest News</a></li>
                                    <li><a href="/">Testimonials</a></li>
                                    <li><a href="/">Our Projects</a></li>
                                    <li><a href="/contact-us">Contact Us</a></li>
                                    </ul>
                                    </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                    <div class="single_footer_widget">
                                    <div class="title">
                                    <h3>Contact Details</h3>
                                    </div>
                                    <ul class="footer_contact_info">
                                    <li>
                                    <div class="text_holder">Breaking St, 2nd Cros,NY ,USA</div>
                                    </li>
                                    <li>
                                    <div class="text_holder">+321 4567 89 012 &amp; 79</div>
                                    </li>
                                    <li>
                                    <div class="text_holder">support@cedcommerce.com</div>
                                    </li>
                                    </ul>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>',
                    'stores' => 0,
                    'is_active' => 1,
                ];
                $this->blockFactory->create()->setData($footerBlockData)->save();
    }
}
}
