<?php

namespace ZfCors;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * Class Module
 *
 * @package ZfCors
 */
class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Returns an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    /**
     * @param \Zend\Mvc\MvcEvent
     *
     * @return void
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();
        $eventManager->attach(
            MvcEvent::EVENT_FINISH,
            function () use ($application, $event) {
                // Gets the current application instance and extracts the service manager from it
                $serviceManager = $application->getServiceManager();

                // Gets the appropriate configs for enabling and injecting CORS headers
                $config = $serviceManager->get('Config');
                if (isset($config['corsHeaders'])) {
                    $corsHeaders = $config['corsHeaders'];

                    // Gets the response object
                    $headers = $event->getResponse()->getHeaders();

                    // Loops through the CORS headers from the config file and injects the headers in the response
                    // object
                    foreach ($corsHeaders as $headerName => $headerValue) {
                        $headers->addHeaderLine($headerName, $headerValue);
                    }
                }
            }
        );
    }
}
