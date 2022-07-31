<?php

namespace Drupal\onesignal_api\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\onesignal_api\ContentTypeAndTokenMappingInterface;

/**
 * Defines the content type and token mapping entity type.
 *
 * @ConfigEntityType(
 *   id = "content_type_and_token_mapping",
 *   label = @Translation("Content type and token mapping"),
 *   label_collection = @Translation("Content type and token mappings"),
 *   label_singular = @Translation("content type and token mapping"),
 *   label_plural = @Translation("content type and token mappings"),
 *   label_count = @PluralTranslation(
 *     singular = "@count content type and token mapping",
 *     plural = "@count content type and token mappings",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\onesignal_api\ContentTypeAndTokenMappingListBuilder",
 *     "form" = {
 *       "add" = "Drupal\onesignal_api\Form\ContentTypeAndTokenMappingForm",
 *       "edit" = "Drupal\onesignal_api\Form\ContentTypeAndTokenMappingForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "content_type_and_token_mapping",
 *   admin_permission = "administer content_type_and_token_mapping",
 *   links = {
 *     "collection" = "/admin/structure/content-type-and-token-mapping",
 *     "add-form" = "/admin/structure/content-type-and-token-mapping/add",
 *     "edit-form" = "/admin/structure/content-type-and-token-mapping/{content_type_and_token_mapping}",
 *     "delete-form" = "/admin/structure/content-type-and-token-mapping/{content_type_and_token_mapping}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "content_type_selection",
 *     "banner_headline",
 *     "article_headline",
 *     "article_link",
 *     "image_url"
 *   }
 * )
 */
class ContentTypeAndTokenMapping extends ConfigEntityBase implements ContentTypeAndTokenMappingInterface {

  /**
   * The content type and token mapping ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The content type and token mapping label.
   *
   * @var string
   */
  protected $label;

  /**
   * The content type and token mapping status.
   *
   * @var bool
   */
  protected $status;

  /**
   * The content_type_and_token_mapping description.
   *
   * @var string
   */
  public $content_type_selection;

  /**
   * The content_type_and_token_mapping description.
   *
   * @var string
   */
  public $banner_headline;

  /**
   * The content_type_and_token_mapping description.
   *
   * @var string
   */
  public $article_headline;

  /**
   * The content_type_and_token_mapping description.
   *
   * @var string
   */
  public $article_link;

  /**
   * The content_type_and_token_mapping description.
   *
   * @var string
   */
  public $image_url;

}
