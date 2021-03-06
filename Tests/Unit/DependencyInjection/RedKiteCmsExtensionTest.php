<?php

namespace RedKiteLabs\RedKiteCmsBundle\Tests\Unit\DependencyInjection;

use RedKiteLabs\RedKiteCmsBundle\Tests\TestCase;
use RedKiteLabs\RedKiteCmsBundle\DependencyInjection\RedKiteCmsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * RedKiteCmsExtensionTest
 *
 * @author RedKite Labs <webmaster@redkite-labs.com>
 */
class RedKiteCmsExtensionTest extends TestCase
{
    private $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
    }

    public function testAlias()
    {
        $extension = new RedKiteCmsExtension();
        $this->assertEquals('red_kite_cms', $extension->getAlias());
    }

    public function testDefaultConfiguration()
    {
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array()), $this->container);
        $this->assertEquals('Propel', $this->container->getParameter('red_kite_cms.orm'));
        $this->assertEquals('bootstrap', $this->container->getParameter('red_kite_cms.skin'));
        $this->assertEquals('web', $this->container->getParameter('red_kite_cms.web_folder'));
        $this->assertEquals('%kernel.root_dir%/../%red_kite_cms.web_folder%', $this->container->getParameter('red_kite_cms.web_folder_full_path'));
        $this->assertEquals(array('en' => 'English', 'it' => 'Italian',), $this->container->getParameter('red_kite_cms.available_languages'));
        $this->assertEquals('uploads/assets', $this->container->getParameter('red_kite_cms.upload_assets_dir'));
        $this->assertEquals('Resources', $this->container->getParameter('red_kite_cms.deploy_bundle.resources_dir'));
        $this->assertEquals('%red_kite_cms.deploy_bundle.resources_dir%/config', $this->container->getParameter('red_kite_cms.deploy_bundle.config_dir'));
        $this->assertEquals('%red_kite_cms.deploy_bundle.resources_dir%/views', $this->container->getParameter('red_kite_cms.deploy_bundle.views_dir'));
        $this->assertEquals('media', $this->container->getParameter('red_kite_cms.deploy_bundle.media_dir'));
        $this->assertEquals('js', $this->container->getParameter('red_kite_cms.deploy_bundle.js_dir'));
        $this->assertEquals('css', $this->container->getParameter('red_kite_cms.deploy_bundle.css_dir'));
        $this->assertEquals('WebSite', $this->container->getParameter('red_kite_cms.deploy_bundle.controller'));
        $this->assertEquals('', $this->container->getParameter('red_kite_cms.website_url'));
        $this->assertEquals('RedKiteLabs\RedKiteCmsBundle\Core\ActiveTheme\AlActiveTheme', $this->container->getParameter('red_kite_cms.active_theme.class'));
        $this->assertEquals('%kernel.root_dir%/Resources/.active_theme', $this->container->getParameter('red_kite_cms.active_theme_file'));
    }

    public function testOrm()
    {
        $this->scalarNodeParameter('red_kite_cms.orm', 'orm', 'Doctine');
    }

    public function testSkin()
    {
        $this->scalarNodeParameter('red_kite_cms.skin', 'skin', 'fancySkin');
    }

    public function testWebFolder()
    {
        $this->scalarNodeParameter('red_kite_cms.web_folder', 'web_folder_dir', 'content');
    }

    public function testWebFolderFullPath()
    {
        $this->scalarNodeParameter('red_kite_cms.web_folder_full_path', 'web_folder_dir_full_path', '/app/full/path/content');
    }

    public function testUploadAssetsDir()
    {
        $this->scalarNodeParameter('red_kite_cms.upload_assets_dir', 'upload_assets_dir', 'new/upload/path');
    }

    public function testDeployResourcesDir()
    {
        $value = 'Assets';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('resources_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.resources_dir'));
    }

    public function testDeployAssetsBaseDir()
    {
        $value = 'Assets/pub';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('assets_base_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.assets_base_dir'));
    }

    public function testDeployConfigDir()
    {
        $value = 'Assets/conf';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('config_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.config_dir'));
    }

    public function testDeployViewDir()
    {
        $value = 'MyRes/templates';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('views_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.views_dir'));
    }

    public function testDeployMediaDir()
    {
        $value = 'MyRes/images';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('media_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.media_dir'));
    }

    public function testDeployJsDir()
    {
        $value = 'MyRes/javascripts';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('js_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.js_dir'));
    }

    public function testDeployCssDir()
    {
        $value = 'MyRes/stylesheets';
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array('deploy_bundle' => array('css_dir' => $value))), $this->container);
        $this->assertEquals($value, $this->container->getParameter('red_kite_cms.deploy_bundle.css_dir'));
    }
    
    public function testWebsiteUrl()
    {
        $this->scalarNodeParameter('red_kite_cms.website_url', 'website_url', 'http://redkite-labs.com');
    }
    
    public function testAtiveThemeFile()
    {
        $this->scalarNodeParameter('red_kite_cms.active_theme_file', 'active_theme_file', '%kernel.root_dir%/new/path');
    }

    private function scalarNodeParameter($parameter, $configKey, $configValue)
    {
        $extension = new RedKiteCmsExtension();
        $extension->load(array(array($configKey => $configValue)), $this->container);
        $this->assertEquals($configValue, $this->container->getParameter($parameter));
    }
}
