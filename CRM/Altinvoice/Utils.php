<?php

class CRM_Altinvoice_Utils {

  public static function getDefaultInvoicePage() {
    $result = civicrm_api3('Setting', 'get', [
              'sequential' => 1,
              'return' => ["default_invoice_page"],
            ])['values'][0]['default_invoice_page'];
    return $result;
  }

}
