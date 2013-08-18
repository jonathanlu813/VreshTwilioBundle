#Symfony2 Twilio Bundle - by Fridolin Koch (Vresh.net)

[![Build Status](https://travis-ci.org/fridolin-koch/VreshTwilioBundle.png?branch=master)](https://travis-ci.org/fridolin-koch/VreshTwilioBundle)

About
-----

This is just a wrapper for the [official SDK](https://github.com/twilio/twilio-php) provided by [Twilio](http://www.twilio.com/).

Installation
------------

Add this to your `composer.json` file:

```json
"require": {
	"vresh/twilio-bundle": "dev-master",
}
```


Add the bundle to `app/AppKernel.php`

```php
$bundles = array(
	// ... other bundles
	new Vresh\TwilioBundle\VreshTwilioBundle(),
);
```

Configuration
-------------

Add this to your `config.yml`:

```yaml
vresh_twilio:
    #(Required) Your Account SID from www.twilio.com/user/account
    sid: 'XXXXXXXX'
    #(Required) Your Auth Token from www.twilio.com/user/account
    authToken: 'YYYYYYYY'
    #(Optional, default: '2010-04-01') Twilio API version
    version: '2008-08-01'
    #(Optional, default: 1) Number of times to retry failed requests
    retryAttempts: 3
```

Usage
-----

Inside a controller:

```php
class TelephoneController extends Controller
{
    public function callAction($me, $maybee)
    {
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
    	$twilio = $this->get('twilio.api');

        $message = $twilio->account->sms_messages->create(
        	'9991231234', // From a valid Twilio number
        	'8881231234', // Text this number
        	"Hello monkey!"
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        return new Response($message->sid);
    }
}
```

Inside a console command:

```php
class SomeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('some:comand')
            ->setDescription('A command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
        $twilio = $this->getContainer()->get('twilio.api');

        $message = $twilio->account->sms_messages->create(
        	'9991231234', // From a valid Twilio number
        	'8881231234', // Text this number
        	"Hello monkey!"
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        print $message->sid;

    }
}
```

Use a Service_Request_Validator

```php
class SMSController extends Controller
{
    public function receiveSmsMessageAction()
    {
        $smsManager = $this->get('stampup_sms.sms_manager');
        $url = $this->getRequest()->getUri();
        $postVars = $this->getRequest()->request->all();
        $signature = $this->getRequest()->server->get('HTTP_X_TWILIO_SIGNATURE');

        $requestValidator = $this->getContainer()->get('twilio.request_validator');

        if (!$requestValidator->validate($signature, $url, $postVars)) {
            throw $this->createNotFoundException('Request not coming from SMS service');
        }

        // Do whatever you want with the received message
    }
}
```

Copyright / License
-------------------

See [LICENSE](https://github.com/fridolin-koch/VreshTwilioBundle/blob/master/LICENSE)
