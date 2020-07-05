<?php

namespace Drupal\mbcemployee\Form\Menu;

use Drupal\mbccommon\Form\MBCCommonFormMenuBase;
use Drupal\mbccommon\Node\MBCCommonTypeNode;

class MBCEmployeeFormViewMenu extends MBCCommonFormMenuBase
{
    /**
     * @return int
     */
    public function getId()
    {
        return 1100500;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        $modules = ['mbccompany', 'mbcemployee'];
        return $this->getMBCCsv()
            ->loadAllModules('user_management', 'menu', $modules)
            ->flatten();
    }
}