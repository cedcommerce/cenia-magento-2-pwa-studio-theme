<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_PwaApi
 * @author 		CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */
 
/**
 * Core Extensions block
 *
 * @category    Ced
 * @package     Ced_PwaApi
 * @author 		CedCommerce Core Team <coreteam@cedcommerce.com>
 */

namespace Ced\PwaApi\Block;
/**
 * @method \Magento\Config\Block\System\Config\Form getForm()
 */
class Extensions extends \Magento\Config\Block\System\Config\Form\Fieldset  
{
	protected $_dummyElement;
	protected $_fieldRenderer;
	protected $_values;
	protected $_licenseUrl;
	const LICENSE_USE_HTTPS_PATH = 'web/secure/use_in_adminhtml';
	const LICENSE_VALIDATION_URL_PATH = 'system/license/license_url';
	const HASH_PATH_PREFIX = 'ced_pwa/extensions/extension_';


	/**
     * Application Object Manager
     *
     * @var \Magento\Framework\App\CacheInterface
     */
	protected $_objectManager;

    /**
     * Cedcommerce helper
     *
     * @var \Ced\CsMarketplace\Helper\Data
     */
    protected $_helper;
    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\View\Helper\Js $jsHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Framework\View\Helper\Js $jsHelper,
		\Magento\Framework\Serialize\Serializer\Json $serializer = null,
        array $data = []
    ) {
        $this->_jsHelper = $jsHelper;

        $this->_authSession = $authSession;
        $this->_objectManager = $objectInterface;
		$this->_helper = $this->_objectManager->get('Ced\PwaApi\Helper\Data');
		$this->_serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
		->get(\Magento\Framework\Serialize\Serializer\Json::class);
        parent::__construct($context, $authSession, $jsHelper);
		$this->_cacheManager = $this->_cache;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
    	
		$header = $html = $footer = $script = '';
		
		$header = $this->_getHeaderHtml($element);
		
		$modules =  $this->_objectManager->get('\Ced\PwaApi\Helper\Feed')->getAllModules();
		
		$field = $element->addField('extensions_heading', 'note', array(
            'name'  => 'extensions_heading',
            'label' => '<a href="javascript:;"><b>Extension Name (version)</b></a>',
            'text' => '<a href="javascript:;"><b>License Information</b></a>',
		))->setRenderer($this->_getFieldRenderer());
		$html.= $field->toHtml();
        foreach ($modules as $moduleName=>$releaseVersion) {

			$moduleProductName = isset($releaseVersion['parent_product_name']) ? $releaseVersion['parent_product_name'] : '';
			if(!is_array($releaseVersion))
				$releaseVersion = isset($releaseVersion['release_version']) ? $releaseVersion['release_version'] : trim($releaseVersion);
			else
				$releaseVersion = isset($releaseVersion['release_version']) ? $releaseVersion['release_version'] : '';
		
			$html.= $this->_getFieldHtml($element, $moduleName,$releaseVersion,$moduleProductName);
		}
		if (strlen($html) == 0) {
			$html = '<p>'.$this->__('No records found.').'</p>';
		}
        $footer .= $this->_getFooterHtml($element);
		
		$script .= $this->_getScriptHtml();
		
        return $header. $html . $footer . $script;
    }
	
    protected function _getFieldRenderer()
    {
    	if (empty($this->_fieldRenderer)) {
    		$this->_fieldRenderer = $this->_objectManager->get('\Magento\Config\Block\System\Config\Form\Field');
    	}
    	return $this->_fieldRenderer;
    }
	
	protected function _getDummyElement()
    {
        if (empty($this->_dummyElement)) {
            $this->_dummyElement = new \Magento\Framework\DataObject(array('show_in_default'=>1, 'show_in_website'=>1));
        }
        return $this->_dummyElement;
    }
	
	protected function _getFieldHtml($fieldset, $moduleName,$currentVersion = '0.0.1',$moduleProductName = '')
    {
    	$hash = \Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.strtolower($moduleName).'_hash';	
    	$level = \Ced\PwaApi\Block\Extensions::HASH_PATH_PREFIX.strtolower($moduleName).'_level';

	 	$helper = $this->_objectManager->create('\Ced\PwaApi\Helper\Data');
		
		$configData[$hash] = $helper->getStoreConfig($hash);
		$configData[$level] = $helper->getStoreConfig($level);

		$hash = isset($configData[$hash])?$configData[$hash] : '';
		$level = isset($configData[$level])?$configData[$level] : '';
		$l = $this->_objectManager->create('\Ced\PwaApi\Helper\Feed')->getLicenseFromHash($hash,$level);
		
        $path = self::HASH_PATH_PREFIX.strtolower($moduleName);
        $configData[$path] = $helper->getStoreConfig($path);

        if (isset($configData[$path])) {
        	
        	$configData[$path] = $l;
            $data = $configData[$path];
            $inherit = false;
        } else {
            $data = '';//(string)$this->getForm()->getConfigRoot()->descend($path);
            $inherit = true;
        }
 
        $e = $this->_getDummyElement();
		$allExtensions = "";
		if($this->_cacheManager->load('all_extensions_by_cedcommerce'))
			$allExtensions  = $this->_serializer->unserialize($this->_cacheManager->load('all_extensions_by_cedcommerce'));
        $name    	    = strlen($moduleProductName) > 0 ? $moduleProductName : $moduleName;
		$releaseVersion = $name.'-'.$currentVersion;
		$warning = '';
		if ($allExtensions && isset($allExtensions[$moduleName])) {
			$url     = $allExtensions[$moduleName]['url'];
            $warning = isset($allExtensions[$moduleName]['warning'])?$allExtensions[$moduleName]['warning']:'';
			
			if(strlen($warning) == 0) {
				$releaseVersion = $allExtensions[$moduleName]['release_version'];
				$releaseVersion = '<a href="'.$url.'" target="_blank" title="Upgarde Available('.$releaseVersion.')">'.$name.'-'.$currentVersion.'</a>';
			} else {
				$releaseVersion = '<div class="notification-global"><strong class="label">'.$warning.'</strong></div>';
			}
		}
		$buttonHtml = '<div style="float: right;"><div style="font-family:\'Admin Icons\';" class="message-success"></div></div>';
		$type = 'label';
		$title = 'License Number';
		if(strlen($data) == 0) {
			$title = __('Enter the valid license after that you have to click on Save Config button.');
		
			$buttonHtml = '<div style="clear: both; height:0; width:0; ">&nbsp;</div>';
			$buttonHtml .= '<p class="note"><span>Please fill the valid license number in above field. If you don\'t have license number please <a href="http://cedcommerce.com/licensing?product_name='.strtolower($moduleName).'" target="_blank">Get a license number from CedCommerce.com</a></span></p>';
			$type = 'text';
		}
		
		
		
	
		$field = $fieldset->addField($moduleName, $type,//this is the type of the element (can be text, textarea, select, multiselect, ...)
			array(
				'name'          => 'groups[extensions][fields][extension_'.strtolower($moduleName).'][value]',//this is groups[group name][fields][field name][value]
				'label'         => $name.' ('.$currentVersion.')',//this is the label of the element
				'value'         => $data,//this is the current value
				'title'			=> $title,
				'inherit'       => $inherit,
				'class'			=>'validate-cedcommerce-license',
				'style'		=> 'float:left;',
				'can_use_default_value' => $this->getForm()->canUseDefaultValue($e),//sets if it can be changed on the default level
				'can_use_website_value' => $this->getForm()->canUseWebsiteValue($e),//sets if can be changed on website level
				'after_element_html' => $buttonHtml,
			))->setRenderer($this->_getFieldRenderer());
		
		/* $field = $fieldset->addField(strtolower($moduleName), 'note', array(
            'name'  => 'csmarketplace',
            'label' => '<span style="text-align: center;">'.$name.'-'.$currentVersion.'</span>',
            'text' => '<span style="text-align: center;">'.$releaseVersion.'</span>',
		))->setRenderer($this->_getFieldRenderer()); */
		
		return $field->toHtml();
    }
	
	/**
     * Retrieve local license url
     *
     * @return string
     */
    public function getLicenseUrl()
    {
        if (is_null($this->_licenseUrl)) {
			$secure = false;
			if($this->_helper->getStoreConfig(self::LICENSE_USE_HTTPS_PATH)) {
				$secure = true;
			}
			$this->_licenseUrl = $this->getUrl($this->_helper->getStoreConfig(self::LICENSE_VALIDATION_URL_PATH),array('_secure'=>$secure));
        }
        
        return $this->geturl('pwaapi/main/license');
    }
	/*
	protected function _getScriptHtml() {
		$script = '<script type="text/javascript">';
		$script .= 'Validation.add("validate-cedcommerce-license", "Please enter a valid License Number.", function(v,licenseElement) {';     
 
		$script .= 'var url = "'.$this->getLicenseUrl().'";';
		$script .= 'var formId = configForm.formId;';
	
		$script .= 'var ok = false;';
		$script .= 'var licenseParam = licenseElement.id + "=" + licenseElement.value;';
		$script .= 'new Ajax.Request(url, {
							method: "post",
							asynchronous: false,
							onSuccess: function(transport) {
								var response = transport.responseText.evalJSON();
								validateTrueEmailMsg = response.message;
								if (response.success == 0) {									
									Validation.get("validate-cedcommerce-license-"+licenseElement.id).error = validateTrueEmailMsg;
									alert(validateTrueEmailMsg);
									ok = false;
								} else {
									ok = true; 
								}
							},
							parameters: licenseParam,
					});
					return ok';
		$script .= '})';
		$script .= '</script>';

		return $script;
	}
	*/

	protected function _getScriptHtml() {
		$script = '<script type="text/javascript">';
		$script.="require([
'jquery', // jquery Library
'jquery/ui', // Jquery UI Library
'jquery/validate', // Jquery Validation Library
'mage/translate' // Magento text translate (Validation message translte as per language)
], function($){ 
$.mage.message =  $.mage.__('Please enter a valid License Number.');
$.validator.addMethod(

'validate-cedcommerce-license', function (value,licenseElement) {";
		$script .= 'var url = "'.$this->getLicenseUrl().'?"+licenseElement.id+"="+licenseElement.value;';
		$script .= 'var formId = configForm.formId;';
	
		$script .= 'var ok = false;console.log(licenseElement.id);' ;
		$script .= "jQuery.ajax( {
		    url: url,
		    type: 'POST',
		    showLoader: true,
		    data: {form_key:jQuery('input[name=form_key]').val()},
		    async:false
		}).done(function(a) { 
		    

		    var response = a.evalJSON();
								validateTrueEmailMsg = response.message;
								if (response.success == 0) {									
									$.mage.message = validateTrueEmailMsg;
									alert(validateTrueEmailMsg);
									ok = false;
								} else {
									ok = true; 
								}
		});
		return ok;
		";

$script.="},$.mage.message);

});
 </script>
";
		
		

		return $script;
	}
}
