<?php

namespace Drupal\mbcemployee\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\mbccommon\MBCCommonServiceTrait;

/**
 * Class MBCEmployeeMainMenuBlock
 *
 * @Block(
 *  id ="mbcemployee_app_menu_block",
 *  admin_label = "Application Menu",
 *  category = "MBC",
 * )
 */
class MBCEmployeeAppBlock extends BlockBase implements BlockPluginInterface
{
    use MBCCommonServiceTrait;

    protected $routes;

    public function access(AccountInterface $account, $return_as_object = false)
    {
        $hasAccess = \Drupal::currentUser()->isAuthenticated();
        return AccessResult::allowedIf($hasAccess);
    }

    public function build()
    {
        $this->setRoutes();
        return $this->buildProfile();
    }

    protected function setRoutes()
    {
        $this->routes = $this->getMBCRoutes()
            ->loadAllModules('main', 'menu')
            ->getRoutes();
    }

    public function buildProfile()
    {

        $form['container-employee'] = [
            '#type' => 'container',
            '#weight' => 1,
        ];

        $form['container-employee']['apps'] = $this->getMBCMenuBuilder()
            ->load($this->routes)
            ->setHeader('User Application', 'user-app', 'plain')
            ->setRequestedMBCNode($this->getMBCUser()->getNode())
            ->build();

        $form['#cache']['max-age'] = 0;

        return $form;
    }
}