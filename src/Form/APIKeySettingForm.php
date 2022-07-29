<?php

namespace Drupal\onesignal_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Configure OneSignal settings for this site.
 */
class APIKeySettingForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'onesignal_api_key_setting';
  }

  /**
   * Constructs the form.
   */
  public function __construct(ConfigFactoryInterface $factory) {
    $this->config = $factory->getEditable('onesignal_api.settings');
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['onesignal_api.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['app_api'] = [
      '#type' => 'textfield',
      '#title' => $this->t('One Signal App Key'),
      '#required' => TRUE,
      '#default_value' => $this->config->get('app_api'),
    ];
    $form['app_rest_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('One Signal App Rest Key'),
      '#required' => TRUE,
      '#default_value' => $this->config->get('app_rest_key'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config
      ->set('app_api', $form_state->getValue('app_api'))
      ->set('app_rest_key', $form_state->getValue('app_rest_key'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
