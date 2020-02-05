<?php

/**
 * Class CRM_Altinvoice_Hook_BuildForm_PreferencesContribute
 *
 * Processes buildForm stage for the Civicontribute preferences form.
 */
class CRM_Altinvoice_Hook_BuildForm_PreferencesContribute {

  /**
   * @var \CRM_Admin_Form_Preferences_Contribute
   */
  private $form;

  /**
   * CRM_Altinvoice_Hook_BuildForm_PreferencesContribute constructor.
   *
   * @param \CRM_Admin_Form_Preferences_Contribute $form
   */
  public function __construct(CRM_Admin_Form_Preferences_Contribute $form) {
    $this->form = $form;
  }

  /**
   * Further processes buildform stage for the given form.
   */
  public function buildForm() {
    $this->addFields();
    $this->addTemplates();
    $this->setDefaults();
  }

  /**
   * Adds ne fields to the form.
   */
  private function addFields() {
    $this->form->add('advcheckbox', 'include_link_to_pay', ts('Include Link to Pay Invoice When Emailing Invoices?'));
  }

  /**
   * Adds templates to the form to show the new fields.
   */
  private function addTemplates() {
    $templatePath = CRM_Altinvoice_ExtensionUtil::path() . '/templates';
    CRM_Core_Region::instance('page-body')->add([
      'template' => "{$templatePath}/CRM/Altinvoice/Form/Settings/IncludeLinkOnEmails.tpl"
    ]);
  }

  /**
   * Sets default values for the new fields on the form.
   */
  private function setDefaults() {
    $isLinkFlagSet = Civi::settings()->get('altinvoice_include_link_to_pay');
    $defaults = $this->form->_defaultValues;
    $defaults['include_link_to_pay'] = $isLinkFlagSet ? TRUE : FALSE;
    $this->form->setDefaults($defaults);
  }

}
