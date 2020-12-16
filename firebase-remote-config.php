<?php 
require dirname(__DIR__).'/api/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\RemoteConfig;
use Kreait\Firebase\Exception\RemoteConfigException;
use Kreait\Firebase\Exception\RemoteConfig\ValidationFailed;
use Kreait\Firebase\RemoteConfig\VersionNumber;
use Kreait\Firebase\RemoteConfig\FindVersions;

// $factory = (new Factory)->withServiceAccount(dirname(__DIR__).'/api/live-support-bot-firebase-adminsdk-r1m24-7f946b04a3.json');
// $remoteConfig = $factory->createRemoteConfig();







/**
 * The Firebase Remote Config.
 *
 * @see https://firebase.google.com/docs/remote-config/use-config-rest
 * @see https://firebase.google.com/docs/remote-config/rest-reference
 */
class CWVRemoteConfig
{
    /** @var ApiClient */
    private $client;

    /** @var ApiClient */
    private $factory;

    /** @var ApiClient */
    private $remoteConfig;

    /** @var ApiClient */
    private $template;

    /**
     * @internal
     */
    public function __construct()
    {
        $this->factory = (new Factory)->withServiceAccount(dirname(__DIR__).'/api/live-support-bot-firebase-adminsdk-r1m24-7f946b04a3.json');
        $this->remoteConfig = $this->factory->createRemoteConfig();
    }

    
    public function setTemplate222($key, $value, $description)
    {
        $this->template = RemoteConfig\Template::new();

        $welcomeMessageParameter = RemoteConfig\Parameter::named($key)
                ->withDefaultValue($value)
                ->withDescription($description);

        $this->template->withParameter($welcomeMessageParameter);

        try {
            $this->remoteConfig->publish($this->template);
        } catch (RemoteConfigException $e) {
            echo $e->getMessage();
        }
    }


    public function setTemplate($key, $value, $description)
    {
        $template = RemoteConfig\Template::new();

        $welcomeMessageParameter = RemoteConfig\Parameter::named($key)->withDefaultValue($value)->withDescription($description);
        $template = $template->withParameter($welcomeMessageParameter);

        try {
            $this->remoteConfig->publish($template);
        } catch (RemoteConfigException $e) {
            echo $e->getMessage();
        }
    }


  

    /**
     * @param Template|array<string, mixed> $template
     *
     * @throws RemoteConfigException
     *
     * @return string The etag value of the published template that can be compared to in later calls
     */
    public function publish()
    {
       
        // try {
        //     // $remoteConfig->validate($template);
        // } catch (ValidationFailed $e) {
        //     echo $e->getMessage();
        // }
        try {
            $this->remoteConfig->publish($this->template);
        } catch (RemoteConfigException $e) {
            echo $e->getMessage();
        }
    }

      /**
     * @throws RemoteConfigException if something went wrong
     */
    public function getTemplate()
    {
        return $this->remoteConfig->get(); // Returns a Kreait\Firebase\RemoteConfig\Template
    }


    /**
     * Returns a version with the given number.
     *
     * @param VersionNumber|int|string $versionNumber
     *
     * @throws VersionNotFound
     * @throws RemoteConfigException if something went wrong
     */
    public function getVersion()
    {
        // $getTemplate = 
       return $this->remoteConfig->get()->version(); 
        // return $getTemplate->version(); 
    }

    /**
     * @param FindVersions|array<string, mixed>|null $query
     *
     * @throws RemoteConfigException if something went wrong
     *
     * @return Traversable<Version>|Version[]
     */
    public function listVersions()
    {
        // $getTemplate = 
       return $this->remoteConfig->get()->version(); 
       // return $getTemplate->version(); 
    }

}

$config = new CWVRemoteConfig();

// echo '<pre>';
// echo '--------------------------------------------------------------------------------------------------------';
// $config->setTemplate('one12222222222222', 'one value', 'one Duration');
// print_r($config->getTemplate() );
// echo '--------------------------------------------------------------------------------------------------------';
// print_r($getTemplate );
// echo '----------------------------------------------$remoteConfig->get()----------------------------------------------------------';
// print_r($remoteConfig->get() );
// exit();
// print_r($version );
