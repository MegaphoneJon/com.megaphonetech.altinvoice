<?php

require_once 'altinvoice.civix.php';
use CRM_Altinvoice_ExtensionUtil as E;


function altinvoice_civicrm_alterMailingRecipients(&$mailingObject, &$criteria, $context) {
  CRM_Core_Error::debug_var('alterMailingRecipients', '1');
}

function altinvoice_civicrm_alterMailParams(&$params, $context) {
  if ($context == 'singleEmail' && $params['valueName'] == 'contribution_invoice_receipt') {
    // Get relationship types that get an alternate invoice.
    $invoiceCustomFieldId = civicrm_api3('CustomField', 'getvalue', [
      'name' => 'invoice_relationship',
      'return' => 'id',
    ]);
    $result = civicrm_api3('RelationshipType', 'get', [
      'return' => ["id"],
      'custom_' . $invoiceCustomFieldId => 1,
      'is_active' => 1,
    ])['values'];
    $relTypes = array_keys($result);
    if ($relTypes) {
      // Get the related contacts in one direction
      $contacts1 = civicrm_api3('Relationship', 'get', [
        'sequential' => 1,
        'return' => ["contact_id_b"],
        'contact_id_a' => $params['contactId'],
        'relationship_type_id' => ['IN' => $relTypes],
              ])['values'];
      $alternateContacts = CRM_Utils_Array::collect('contact_id_b', $contacts1);
      $contacts2 = civicrm_api3('Relationship', 'get', [
                'sequential' => 1,
                'return' => ["contact_id_a"],
                'contact_id_b' => $params['contactId'],
                'relationship_type_id' => ['IN' => [$relTypes]],
              ])['values'];
      $alternateContacts = array_merge($alternateContacts, CRM_Utils_Array::collect('contact_id_b', $contacts2));
      // NOTE: This gets primary, not billing emails - but so does core.  See CRM-17784.
      if ($alternateContacts) {
        $altEmailRecords = civicrm_api3('Email', 'get', [
          'sequential' => 1,
          'return' => ["email"],
          'contact_id' => ['IN' => $alternateContacts],
          'is_primary' => 1,
        ])['values'];
        $altEmails = CRM_Utils_Array::collect('email', $altEmailRecords);
        $altEmails = rtrim(implode(',', $altEmails), ',');
        $params['cc'] = $altEmails;
      }
    }
    // Hack in a link to the invoice ID.
    if ($context == 'singleEmail' && $params['valueName'] == 'contribution_invoice_receipt') {
      //$invoicePage = CRM_Altinvoice_Utils::getDefaultInvoicePage();
      $checksum = CRM_Contact_BAO_Contact_Utils::generateChecksum($params['contactId']);
      $urlParams = [
        'reset' => 1,
        'id' => $params['tplParams']['id'],
        'cs' => $checksum,
      ];
      $payUrl = CRM_Utils_System::url('civicrm/user', $urlParams, TRUE);
      $params['text'] .= "\nClick here to pay this invoice: $payUrl";
      $params['html'] .= "<p>Click here to <a href='$payUrl'>pay this invoice</a>.</p>";
    }
    CRM_Core_Error::debug_var('params', $params);
    CRM_Core_Error::debug_var('context', $context);
  }
}
/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function altinvoice_civicrm_config(&$config) {
  _altinvoice_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function altinvoice_civicrm_xmlMenu(&$files) {
  _altinvoice_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function altinvoice_civicrm_install() {
  _altinvoice_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function altinvoice_civicrm_postInstall() {
  _altinvoice_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function altinvoice_civicrm_uninstall() {
  _altinvoice_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function altinvoice_civicrm_enable() {
  _altinvoice_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function altinvoice_civicrm_disable() {
  _altinvoice_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function altinvoice_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _altinvoice_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function altinvoice_civicrm_managed(&$entities) {
  _altinvoice_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function altinvoice_civicrm_caseTypes(&$caseTypes) {
  _altinvoice_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function altinvoice_civicrm_angularModules(&$angularModules) {
  _altinvoice_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function altinvoice_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _altinvoice_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function altinvoice_civicrm_entityTypes(&$entityTypes) {
  _altinvoice_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function altinvoice_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function altinvoice_civicrm_navigationMenu(&$menu) {
  _altinvoice_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _altinvoice_civix_navigationMenu($menu);
} // */
