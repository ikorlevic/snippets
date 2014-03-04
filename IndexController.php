<?php
/**
 * Created by PhpStorm.
 * User: Zdenko
 * Date: 16.09.13.
 * Time: 08:38
 */

class Proodos_ProductsAction_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle('Proizvodi na akciji');

        $this->renderLayout();
    }
}
