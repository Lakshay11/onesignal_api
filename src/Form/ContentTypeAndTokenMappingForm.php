<?php

namespace Drupal\onesignal_api\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Content type and token mapping form.
 *
 * @property \Drupal\onesignal_api\ContentTypeAndTokenMappingInterface $entity
 */
class ContentTypeAndTokenMappingForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    // dump($this->entity); die();
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the content type and token mapping.'),
      '#required' => TRUE,
    ];

    $types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();
    $contentTypes = [];
    foreach ($types as $item) {
      $contentTypes[$item->id()] = $item->label();
    }

    // Location filter dropdown.
    $form['content_type_selection'] = [
      '#key_type' => 'associative',
      '#type' => 'select',
      '#options' => $contentTypes,
      '#title' => 'Select Content Type',
      '#default_value' => $this->entity->content_type_selection,
    ];

    $form['banner_headline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Banner Headline'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Banner Headline'),
      '#required' => TRUE,
      '#default_value' => $this->entity->banner_headline,
    ];

    $form['article_headline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Article Headline'),
      '#size' => 60,
      '#maxlength' => 128,
      '#description' => $this->t('Article Headline'),
      '#required' => TRUE,
      '#default_value' => $this->entity->article_headline,
    ];

    $form['article_link'] = [
      '#type' => 'url',
      '#title' => $this->t('Article Link'),
      '#maxlength' => 255,
      '#size' => 30,
      '#description' => $this->t('Link to reach Article.'),
      '#required' => TRUE,
      '#default_value' => $this->entity->article_link,
    ];

    $form['image_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Image URL'),
      '#maxlength' => 255,
      '#size' => 30,
      '#description' => $this->t('Link to Image, to show in'),
      '#required' => TRUE,
      '#default_value' => $this->entity->image_url,
    ];

    $form['token_help'] = [
      '#theme' => 'token_tree_link',
      '#token_types' => ['node'],
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\onesignal_api\Entity\ContentTypeAndTokenMapping::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $this->entity->status(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new content type and token mapping %label.', $message_args)
      : $this->t('Updated content type and token mapping %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
