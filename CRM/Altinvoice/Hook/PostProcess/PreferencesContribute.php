<?php

class CRM_Altinvoice_Hook_PostProcess_PreferencesContribute {

  /**
   * Form to be post processed.
   *
   * @var \CRM_Admin_Form_Preferences_Contribute
   */
  private $form;

  public function __construct(CRM_Admin_Form_Preferences_Contribute$form) {
    $this->form = $form;
  }

  /**
   * Post-processes the form.
   */
  public function postProcess() {
    $isIncludePaymentLink = $this->form->getElementValue('include_link_to_pay');

    if ($isIncludePaymentLink) {
      Civi::settings()->set('altinvoice_include_link_to_pay', TRUE);
    } else {
      Civi::settings()->set('altinvoice_include_link_to_pay', FALSE);
    }
  }

}
