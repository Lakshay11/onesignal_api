<?php

namespace Drupal\onesignal_api;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * TriggerOneSignal service.
 */
class TriggerOneSignal {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Definition \Drupal\Core\Config\ImmutableConfig.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Variable to declare article title.
   */
  public $atitle;

  /**
   * Variable to declare article heading.
   */
  public $ahead;

  /**
   * Variable to declare article image link.
   */
  public $aimg;

  /**
   * Variable to declare article link.
   */
  public $alink;

  /**
   * App key for OneSignal App.
   */
  protected $appKey;

  /**
   * Rest key for OneSignal App.
   */
  protected $appRestKey;


  /**
   * The Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a TriggerOneSignal object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(ClientInterface $http_client, ConfigFactoryInterface $factory, MessengerInterface $messenger, LoggerChannelFactoryInterface $logger) {
    $this->httpClient = $http_client;
    $this->config = $factory->get('onesignal_api.settings');
    $this->appKey = $this->config->get('app_api');
    $this->appRestKey = $this->config->get('app_rest_key');
    $this->messenger = $messenger;
    $this->logger = $logger;
  }

  /**
   * Depency indection create function.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Param container.
   * @param array $configuration
   *   Param config.
   *
   * @return array
   *   Return DI array.
   */
  public static function create(ContainerInterface $container, array $configuration) {
    return new static(
      $configuration,
      $container->get('config.factory'),
      $container->get('logger.factory')->get('onesignal_api')
    );
  }

  /**
   * Onesignal post method.
   */
  public function posts($atitle, $ahead, $aimg, $alink) {
    try {
      $response = $this->httpClient->request('POST', 'https://onesignal.com/api/v1/notifications', [
        'body' => '{
          "app_id":"' . $this->appKey . '",
          "included_segments":["Subscribed Users"],
          "contents": { "en":" ' . $atitle . ' "},
          "headings": { "en":"  ' . $ahead . ' "},
          "url": " ' . $alink . ' ",
          "chrome_web_image": "' . $aimg . '",
          "ios_attachments": {"id1": "' . $aimg . '"},
          "big_picture": "' . $aimg . '"
        }',
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => 'Basic ' . $this->appRestKey . '',
          'Content-Type' => 'application/json',
        ],
      ]);
      if ($response->getStatusCode() == 200) {
        $this->messenger->addMessage("Notifaction was sent");
      }
      else {
        $this->messenger->addMessage("Notifaction Sending Failed");
      }
    }
    catch (Exception $e) {
      $this->logger->get('onesignal_api')->error($e->getMessage());
    }
    return $response;
  }

}
