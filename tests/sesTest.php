<?php

/**
 * SimpleEmailService Class test.
 *
 * PHP Version 5 | 7
 *
 * @category Class
 * @package  AmazonSimpleEmailService
 * @author   Okamos <okamoto@okamos.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/okamos/php-ses
 */
use PHPUnit\Framework\TestCase;

// TODO: test identities count.
class sesTest extends TestCase
{
    /**
     * Setup AWS Account from ENVIRONMENT variables.
     * * AWS_ACCESS_KEY_ID
     * * AWS_SECRET_ACCESS_KEY
     * * REGION_NAME
     */
    public function __construct()
    {
        $aws_key = getenv('AWS_ACCESS_KEY_ID');
        $aws_secret = getenv('AWS_SECRET_ACCESS_KEY');
        $region = getenv('REGION');

        $this->_email = 'okamos@okamos.com';
        $this->_domain = 'okamos.com';
        $this->_client = new SimpleEmailService(
            array(
                'aws_access_key_id' => $aws_key,
                'aws_secret_access_key' => $aws_secret,
                'region' => $region
            )
        );
    }

    public function testVerifyEmailIdentity()
    {
        $requestId = $this->_client->verifyEmailIdentity($this->_email);
        $this->assertNotEmpty($requestId);
    }

    public function testListIdentities()
    {
        $identities =  $this->_client->listIdentities();
        $this->assertContains($this->_email, $identities);
    }

    public function testDeleteIdentity()
    {
        $requestId = $this->_client->deleteIdentity($this->_email);
        $this->assertNotEmpty($requestId);
    }

    public function testGetIdentityVerificationAttributes()
    {
        $entries = $this->_client->getIdentityVerificationAttributes(
            [$this->_domain]
        );
        $this->assertEquals(
            'Success', $entries->entry[0]->value->VerificationStatus
        );
    }
}
?>
