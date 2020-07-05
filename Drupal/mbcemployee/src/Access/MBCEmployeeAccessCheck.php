<?php

namespace Drupal\mbcemployee\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\mbccommon\Access\MBCCommonAccessChecker;
use Drupal\mbccommon\Access\MBCCommonAccessCheckerInterface;

class MBCEmployeeAccessCheck extends MBCCommonAccessChecker implements MBCCommonAccessCheckerInterface
{
    public function access(AccountInterface $account)
    {
        $AccessResult = parent::access($account);

        if ($AccessResult->isAllowed()) {
            $hasAccess = $this->isOwner($account, $this->requestedParam);
            return AccessResult::allowedIf($hasAccess);
        } else {
            return $AccessResult;
        }
    }
}