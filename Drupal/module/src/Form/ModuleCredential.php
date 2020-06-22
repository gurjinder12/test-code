<?php

namespace Drupal\module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * module credentails form.
 *
 *  @package Drupal\module\Form
 */
class ModuleCredential extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'module_credentials_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'module.credentials',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $config = $this->config('module.credentials');

    $form['module_api_url'] = [
      '#title' => $this->t('API URL'),
      '#type' => 'url',
      '#default_value' => $config->get('module_api_url'),
      '#required' => TRUE,
    ];

    $form['module_access_key'] = [
      '#title' => $this->t('Access key'),
      '#type' => 'textfield',
      '#default_value' => $config->get('module_access_key'),
      '#maxlength' => 500,
      '#required' => TRUE,
    ];

    $form['module_api_version'] = [
      '#title' => $this->t('API version'),
      '#type' => 'textfield',
      '#default_value' => $config->get('module_api_version'),
      '#maxlength' => 500,
      '#required' => TRUE,
    ];

    $form['module_output_type'] = [
      '#title' => $this->t('Output type'),
      '#type' => 'select',
      '#options' => [
        'json' => $this->t('JSON encoded arrays and strings'),
        'xml' => $this->t('XML encoded arrays and plain-text strings'),
      ],
      '#default_value' => $config->get('module_output_type'),
      '#required' => TRUE,
    ];

    $form['module_ancillary_key'] = [
      '#title' => $this->t('Ancillary key'),
      '#type' => 'textfield',
      '#default_value' => $config->get('module_ancillary_key'),
      '#maxlength' => 500,
      '#required' => TRUE,
    ];

    $form['module_approved_mls'] = [
      '#title' => $this->t('Approved MLS'),
      '#type' => 'textfield',
      '#default_value' => $config->get('module_approved_mls'),
      '#maxlength' => 500,
      '#required' => TRUE,
    ];

    $form['module_api_scheduler'] = [
      '#title' => $this->t('Scheduler'),
      '#type' => 'integer',
      '#description' => $this->t('Set API call scheduler value in minutes.'),
      '#default_value' => $config->get('module_api_scheduler'),
      '#maxlength' => 500,
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get all the form state values, in an array structure.
    $form_state_values = $form_state->getValues();

    $config = $this->config('module.credentials');
    $config->set('module_api_url', $form_state_values['module_api_url']);
    $config->set('module_access_key', $form_state_values['module_access_key']);
    $config->set('module_api_version', $form_state_values['module_api_version']);
    $config->set('module_output_type', $form_state_values['module_output_type']);
    $config->set('module_ancillary_key', $form_state_values['module_ancillary_key']);
    $config->set('module_approved_mls', $form_state_values['module_approved_mls']);
    $config->set('module_api_scheduler', $form_state_values['module_api_scheduler']);
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
