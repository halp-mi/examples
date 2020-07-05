<?php

namespace Drupal\mbcemployee\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase
{

    /**
     * Route user.register to MBC Employee(user) registration form instead
     * {@inheritdoc}
     */
    protected function alterRoutes(RouteCollection $collection)
    {
        if ($route = $collection->get('user.register')) {
            $route->setDefaults([
                    '_form' => '\Drupal\mbcemployee\Form\MBCEmployeeFormRegistration']
            );
        }
    }

}