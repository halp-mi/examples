<?php

namespace Drupal\mbcemployee\Controller;

use Drupal\mbccommon\Controller\MBCCommonController;

/**
 * Our system use a centralized controller function to determine the action to be taken when accepting a request.
 *
 * Class MBCEmployeeController
 * @package Drupal\mbcemployee\Controller
 */
class MBCEmployeeController extends MBCCommonController
{
    public function getModuleId()
    {
        return 110000;
    }
}

