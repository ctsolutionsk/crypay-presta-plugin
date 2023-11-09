<?php
/**
 *  @author    CryPay <info@crypay.com>
 *  @copyright 2023 CryPay
 *  @license   https://www.opensource.org/licenses/MIT  MIT License
 */

class CrypayPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;

    public function initContent()
    {
        parent::initContent();

        $id_order = Tools::getValue('id_order');

        $cart = $this->context->cart;

        if (!$this->module->checkCurrency($cart)) {
            Tools::redirect('index.php?controller=order');
        }

        $this->context->smarty->assign(array(
            'nbProducts'    => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies'    => $this->module->getCurrency((int)$cart->id_currency),
            'total'         => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path'     => $this->module->getPathUri(),
            'this_path_bw'  => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true)
                . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/'
        ));

        $this->setTemplate('crypay_payment_execution.tpl');
    }
}
