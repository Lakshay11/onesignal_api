<?php

namespace Drupal\onesignal_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\onesignal_api\TriggerOneSignal;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a OneSignal form.
 */
class OneSignalNotifyForm extends FormBase {

  protected $notifier;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('onesignal_api.send'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(TriggerOneSignal $notifier) {
    $this->notifier = $notifier;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'onesignal_api_one_signal_notify';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['banner_headline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Banner Headline'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Banner Headline'),
      '#required' => TRUE,
    ];

    $form['article_headline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Article Headline'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Article Headline'),
      '#required' => TRUE,
    ];

    $form['article_link'] = [
      '#type' => 'url',
      '#title' => $this->t('Article Link'),
      '#maxlength' => 255,
      '#size' => 30,
      '#description' => $this->t('Link to reach Article.'),
      '#required' => TRUE,
    ];

    $form['image_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Image URL'),
      '#maxlength' => 255,
      '#size' => 30,
      '#description' => $this->t('Link to Image, to show in'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   *
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->notifier->posts(
      $atitle = $values['banner_headline'],
      $ahead = $values['article_headline'],
      $aimg = $values['image_url'],
      $alink = $values['article_link']
    );
  }

}
