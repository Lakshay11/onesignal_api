<?php

namespace Drupal\Tests\onesignal_api\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests the API Form for the OneSignal API.
 *
 * @group onesignal_api
 */
class OneSignalKeyInputTest extends BrowserTestBase {

  protected $defaultTheme = 'stark';

  protected static $modules = ['onesignal_api'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() :void {
    parent::setUp();
    // Define the required permissions to access the page.
    $permissions = [
      'access administration pages',
      'administer site configuration',
    ];
    $this->adminUser = $this->drupalCreateUser($permissions);
    $this->drupalLogin($this->adminUser);
  }

  /**
   * Make sure the form page works.
   */
  public function testOneSignalAPIPage() {
    $this->drupalGet('/admin/config/system/onesignal');
    $this->assertSession()->statusCodeEquals(200);
  }

}
