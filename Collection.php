<?php
/**
 * Created by PhpStorm.
 * User: Iva
 * Date: 16.09.13.
 * Time: 09:08
 */
class Proodos_OutOfStock_Block_Collection extends Mage_Catalog_Block_Product_List
{
    protected $_productCollection;

    public function getFilter(){
        $array = array();
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection ->addAttributeToSelect('*');
        $collection ->joinField(
            'qty',
            'cataloginventory/stock_item',
            'qty',
            'product_id=entity_id',
            '{{table}}.stock_id=1',
            'left'
        )
            ->addAttributeToFilter('qty', array('eq' => 0))
            ->addAttributeToFilter('is_saleable',array('eq' => '0'));



        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        foreach($collection as $product):
            if(!$product->isSaleable()){
                $array[]=$product->getData('entity_id');
            }
        endforeach;
        return $array;
    }
    public function _getProductCollection(){
        if (is_null($this->_productCollection)) {
            $collection = Mage::getModel('catalog/product')->getCollection();
            $collection ->addAttributeToSelect('*');
            $filters = $this->getFilter();
            $collection -> addAttributeToFilter('entity_id', array('in'=>$filters));

            $this->_productCollection = $collection;

        }
        return $this->_productCollection;
    }

    public function getBlockTitle()
    {
        $title = $this->getTitle();
        if (empty($title)) {
            $title = 'Sold Out Goodies';
        }
        return $title;
    }
}