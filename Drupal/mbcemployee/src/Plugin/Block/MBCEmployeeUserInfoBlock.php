<?php

namespace Drupal\mbcemployee\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\mbccommon\MBCCommonServiceTrait;

/**
 * Class MBCEmployeeUserInfoBlock
 *
 * @Block(
 *  id ="mbcemployee_user_info_block",
 *  admin_label = "User's Info Block",
 *  category = "MBC",
 * )
 */
class MBCEmployeeUserInfoBlock extends MBCEmployeeMainMenuBlock
{
    use MBCCommonServiceTrait;

    public function access(AccountInterface $account, $return_as_object = FALSE)
    {
        return AccessResult::allowedIf(\Drupal::currentUser()->isAuthenticated());
    }

    public function buildProfile()
    {
        $form = [];

        $mbcUser = $this->getMBCUser();
        $userInfo = $mbcUser->userInfo('info');

        $rows = [
            'Name', $userInfo['name_last'] . ', ' . $userInfo['name_first'],
            'Industry', $userInfo['industry'],
            'Roles', implode(', ', $mbcUser->userInfo('roles')),
        ];

        if ($lastAccessed = $this->getCurrentUser()->getLastAccessedTime()) {
            $lastAccessed = \Drupal::service('date.formatter')->format($lastAccessed);
            $rows[] = ['Last Login', $this->t($lastAccessed)];
        }

        $MBCMenuBuilder = $this->getMBCMenuBuilder()
            ->load('user_application')
            ->setHeader('', 'user-info', 'left')
            ->setValidationType(NULL)
            ->disableTitle();

        $form['menu'] = $MBCMenuBuilder->build();

        $form['profile-table'] = [
            '#type' => 'table',
            '#caption' => $this->t('User Profile'),
            '#rows' => $rows,
            '#attributes' => ['class' => ['mbc-table']],
            '#weight' => -10,
        ];

        return $form;
    }
}