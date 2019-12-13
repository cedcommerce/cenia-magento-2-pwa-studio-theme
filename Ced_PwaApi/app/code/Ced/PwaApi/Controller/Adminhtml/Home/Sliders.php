<?php

namespace Ced\PwaApi\Controller\Adminhtml\Home;

class Sliders extends \Magento\Backend\App\Action
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Ced\PwaApi\Model\ResourceModel\PwaSlider\Collection $collection,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
       
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory=$jsonFactory;
        $this->collection = $collection;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
            $position = $this->getRequest()->getParam('position');
            $type = $this->getRequest()->getParam('type');
            $slideLists = $this->collection->addFieldToFilter('code',$type);
            $resultJson = $this->resultJsonFactory->create();
            if($type=="banner" || $type=="slider"){
                $html = '<table>';
                $option = "";
                foreach ($slideLists as $list) {
                    $option = $option.'<tr><td><a id="'.$list->getCode().'-'.$list->getId().'" class="list-slider" >Select</a></td><td>'.$list->getId().'</td><td>'.$list->getSliderName().'</td><td>'.$list->getContent().'</td></tr>';
                }
                $html = $html.$option.' </table>';
                return $resultJson->setData($html);
            }else if($type=="category"){
                $select = '<select class="admin__control-select" name="category-name-'.$position.'[]">';
                $option = "";
                $categories = $this->getCategoryCollection();
                foreach ($categories as $category) {
                $option = $option.'<option class="opt-values" id="opt'.$category->getId().'" value="'.$category->getId().'">'.$category->getName().'</option>';
                }
                $select = $select.$option.'</select>';
                $html = '<div>
                        <div class="admin__field commission_type">
                            <label class="label admin__field-label"><strong>'.__("Category Listing").'</strong></label>
                        </div>
                        <div class="admin__field miscellaneous_commission">
                            <table class="admin__control-table">
                                <thead>
                                    <tr>
                                        <th>'.__("Category Name").'</th>
                                        <th>'.__("Text").'</th>
                                        <th>'.__("Img").'</th>
                                        <th>'.__("Url").'</th>
                                        <th>'.__("Action").'</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="col-actions-add">
                                            <button id="addoption-'.$position.'" class="addoption" title="Add" type="button">
                                                <span>'.__("Add").'</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                                <tbody id="addRow">
                                        <tr>
                                        <td>'.$select.'</td>
                                        <td><input value="" class="admin__control-text" type="text" name="category-text-'.$position.'[]"></td>
                                        <td><input value="" class="admin__control-text" type="text" name="category-img-'.$position.'[]"></td>
                                        <td><input value="" class="admin__control-text" type="text" name="category-url-'.$position.'[]"></td>
                                        <td><button onclick="deleterow(this)" class="action-delete" type="button"><span>'.__("Delete").'</span></button></td>
                                        </tr>       
                                </tbody>
                            </table>
                        </div>
                    </div>';
                    return $resultJson->setData($html);
            }
            
    }

    public function getCategoryCollection() {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter("entity_id",['neq'=>'630']);
        $collection->addAttributeToFilter("parent_id",2);
        $collection->addAttributeToFilter("entity_id",['neq'=>'2']);
        $collection->addIsActiveFilter();
        $collection->addLevelFilter(2);
        
        return $collection;
    }
}
