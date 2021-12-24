<?php
class SitemapController extends AdminBaseController
{
    private $siteMapLanguages = [];
    private $defaultLangId = 0;


    public function __construct($action)
    {
        parent::__construct($action);
        $this->siteMapLanguages = Language::getAllNames(false);
        $this->defaultLangId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
    }

    public function generate()
    {
        set_time_limit(0);
        global $sitemapListInc;
        $sitemapListInc = 0;

        $this->writePrimarySitemapIndex();

        if (1 < count($this->siteMapLanguages)) {
            $this->writeSitemapLangSpecific();
        }

        $structure = $this->getStructure();
        foreach ($structure as $val) {
            $this->writeSitemapIndex($val);
        }
        Message::addMessage(Labels::getLabel('MSG_SITEMAP_HAS_BEEN_UPDATED_SUCCESSFULLY', $this->siteLangId));
        CommonHelper::redirectUserReferer();
    }

    private function writeSitemapIndex($type)
    {
        switch ($type) {
            case 'products':
                $this->writeProductSitemap();
                break;
            case 'categories':
                $this->writeCategorySitemap();
                break;
            case 'brands':
                $this->writeBrandSitemap();
                break;
            case 'shops':
                $this->writeShopSitemap();
                break;
            case 'cms':
                $this->writeCmsSitemap();
                break;
        }
    }

    private function getProductSrchObj($langId = 0)
    {
        $prodSrchObj = new ProductSearch($langId);
        $prodSrchObj->setDefinedCriteria(1);
        $prodSrchObj->joinProductToCategory();
        $prodSrchObj->joinSellerSubscription();
        $prodSrchObj->addSubscriptionValidCondition();
        $prodSrchObj->doNotCalculateRecords();
        $prodSrchObj->doNotLimitRecords();
        return $prodSrchObj;
    }

    private function writeProductSitemap()
    {
        $prodSrch = $this->getProductSrchObj();

        foreach ($this->siteMapLanguages as $language) {
            $this->startSitemapXml();
            $url = UrlHelper::getUrlScheme();
            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $url .=  '/' . strtolower($language['language_code']);
                $file .= '/' . strtolower($language['language_code']);
            }
            $file .= '/products';

            $prodSrch->addMultipleFields(array('selprod_id'));
            $prodSrch->addGroupBy('selprod_id');
            $prodSrch->doNotCalculateRecords();
            $prodSrch->doNotLimitRecords();
            $rs = $prodSrch->getResultSet();
            while ($row = FatApp::getDb()->fetch($rs)) {
                $this->writeSitemapUrl(UrlHelper::generateFullUrl('products', 'view', array($row['selprod_id']), CONF_WEBROOT_FRONT_URL, null, false, false, true, $language['language_id']), $file);
            }

            $this->endSitemapXml($file);
        }
    }

    private function writeCategorySitemap()
    {
        foreach ($this->siteMapLanguages as $language) {
            $this->startSitemapXml();
            $url = UrlHelper::getUrlScheme();

            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $url .=  '/' . strtolower($language['language_code']);
                $file .= '/' . strtolower($language['language_code']);
            }
            $file .= '/categories';

            $categoriesArr = ProductCategory::getArray($this->siteLangId, 0, false, true, false, CONF_USE_FAT_CACHE, false);
            foreach ($categoriesArr as $key => $val) {
                $this->writeSitemapUrl(UrlHelper::generateFullUrl('category', 'view', array($val['prodcat_id']), CONF_WEBROOT_FRONT_URL, null, false, false, true, $language['language_id']), $file);
            }
            $this->endSitemapXml($file);
        }
    }

    private function writeBrandSitemap()
    {
        foreach ($this->siteMapLanguages as $language) {
            $prodSrchObj = $this->getProductSrchObj($language['language_id']);
            $this->startSitemapXml();
            $url = UrlHelper::getUrlScheme();
            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $url .=  '/' . strtolower($language['language_code']);
                $file .= '/' . strtolower($language['language_code']);
            }
            $file .= '/brands';

            $brandSrch = clone $prodSrchObj;
            $brandSrch->addMultipleFields(array('brand_id'));
            $brandSrch->addGroupBy('brand_id');
            $brandSrch->addOrder('brand_name');
            $brandSrch->doNotCalculateRecords();
            $brandSrch->doNotLimitRecords();
            $brandRs = $brandSrch->getResultSet();
            while ($row = FatApp::getDb()->fetch($brandRs)) {
                $this->writeSitemapUrl(UrlHelper::generateFullUrl('brands', 'view', array($row['brand_id']), CONF_WEBROOT_FRONT_URL, null, false, false, true, $language['language_id']), $file);
            }

            $this->endSitemapXml($file);
        }
    }

    private function writeShopSitemap()
    {
        foreach ($this->siteMapLanguages as $language) {
            $this->startSitemapXml();
            $url = UrlHelper::getUrlScheme();
            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $url .=  '/' . strtolower($language['language_code']);
                $file .= '/' . strtolower($language['language_code']);
            }
            $file .= '/shops';

            $shopSrch = new ShopSearch();
            $shopSrch->setDefinedCriteria();
            $shopSrch->joinShopCountry();
            $shopSrch->joinShopState();
            $shopSrch->joinSellerSubscription();
            $shopSrch->doNotCalculateRecords();
            $shopSrch->doNotLimitRecords();
            $shopSrch->addMultipleFields(array('shop_id'));
            $rs = $shopSrch->getResultSet();
            while ($row = FatApp::getDb()->fetch($rs)) {
                $this->writeSitemapUrl(UrlHelper::generateFullUrl('shops', 'view', array($row['shop_id']), CONF_WEBROOT_FRONT_URL, null, false, false, true, $language['language_id']), $file);
            }

            $this->endSitemapXml($file);
        }
    }

    private function writeCmsSitemap()
    {
        foreach ($this->siteMapLanguages as $language) {
            $this->startSitemapXml();
            $url = UrlHelper::getUrlScheme();
            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $url .=  '/' . strtolower($language['language_code']);
                $file .= '/' . strtolower($language['language_code']);
            }
            $file .= '/cms';

            $cmsSrch = new NavigationLinkSearch();
            $cmsSrch->joinNavigation();
            $cmsSrch->joinProductCategory();
            $cmsSrch->joinContentPages();
            $cmsSrch->doNotCalculateRecords();
            $cmsSrch->doNotLimitRecords();
            $cmsSrch->addOrder('nav_id');
            $cmsSrch->addOrder('nlink_display_order');

            $cmsSrch->addCondition('nlink_deleted', '=', '0');
            $cmsSrch->addCondition('nav_active', '=', applicationConstants::ACTIVE);
            $cmsSrch->addMultipleFields(array('nlink_cpage_id, nlink_type'));
            $rs = $cmsSrch->getResultSet();
            while ($row = FatApp::getDb()->fetch($rs)) {
                if ($row['nlink_type'] == NavigationLinks::NAVLINK_TYPE_CMS && $row['nlink_cpage_id']) {
                    $this->writeSitemapUrl(UrlHelper::generateFullUrl('Cms', 'view', array($row['nlink_cpage_id']), CONF_WEBROOT_FRONT_URL, null, false, false, true, $language['language_id']), $file);
                }
            }
            $this->endSitemapXml($file);
        }
    }


    private function startSitemapXml()
    {
        ob_start();
        echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    }

    private function writeSitemapUrl($url, $file, $freq = 'weekly')
    {
        static $sitemap_i;
        $sitemap_i++;
        if ($sitemap_i > 2000) {
            $sitemap_i = 1;
            $this->endSitemapXml($file, true);
            $this->startSitemapXml();
        }
        echo "
			<url>
				<loc>" . $url . "</loc>
                <lastmod>" . date('Y-m-d') . "</lastmod>
                <changefreq>" . $freq . "</changefreq>
                <priority>0.8</priority>
			</url>";
        echo "\n";
    }

    private function endSitemapXml($file, $changeList = false)
    {
        global $sitemapListInc;
        if ($changeList) {
            $sitemapListInc++;
        }

        $file = (1 >  $sitemapListInc) ? $file : $file . $sitemapListInc;

        echo '</urlset>' . "\n";
        $contents = ob_get_clean();
        $rs = '';
        CommonHelper::writeFile($file . '.xml', $contents, $rs);
    }

    private function writePrimarySitemapIndex()
    {
        ob_start();
        echo "<?xml version='1.0' encoding='UTF-8'?>
		<sitemapindex xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        if (1 < count($this->siteMapLanguages)) {
            foreach ($this->siteMapLanguages as $language) {
                $url = UrlHelper::getUrlScheme() . '/sitemap';
                // $url .=  "/" . strtolower($language['language_code']);
                if ($this->defaultLangId != $language['language_id']) {
                    $url .=  "/" . strtolower($language['language_code']);
                }
                echo "<sitemap><loc>" . $url . "/sitemap.xml</loc></sitemap>\n";
            }
        } else {
            $structure = $this->getStructure();
            foreach ($structure as $val) {
                echo "<sitemap><loc>" . UrlHelper::getUrlScheme() . '/sitemap' . '/' . strtolower($val) . ".xml</loc></sitemap>\n";
            }
        }

        echo "</sitemapindex>";
        $contents = ob_get_clean();
        $rs = '';
        CommonHelper::writeFile('sitemap.xml', $contents, $rs);
    }

    private function writeSitemapLangSpecific()
    {
        $structure = $this->getStructure();
        foreach ($this->siteMapLanguages as $language) {
            $this->startSitemapXml();
            foreach ($structure as $val) {
                $url = UrlHelper::getUrlScheme() . '/sitemap';
                if ($this->defaultLangId != $language['language_id']) {
                    $url .=  "/" . strtolower($language['language_code']);
                }
                $url .= "/" . strtolower($val) . '.xml';

                echo "
                <url>
                    <loc>" . $url . "</loc>
                    <lastmod>" . date('Y-m-d') . "</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                </url>";
                echo "\n";
            }

            echo '</urlset>' . "\n";
            $contents = ob_get_clean();
            $rs = '';

            $file = 'sitemap';
            if ($this->defaultLangId != $language['language_id']) {
                $file .= '/' . strtolower($language['language_code']);
            }

            CommonHelper::writeFile($file . '/sitemap.xml', $contents, $rs);
        }
    }

    private function getStructure()
    {
        return  [
            'products',
            'categories',
            'brands',
            'shops',
            'cms'
        ];
    }
}
