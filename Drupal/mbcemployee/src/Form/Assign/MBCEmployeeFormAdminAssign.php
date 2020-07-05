<?php

namespace Drupal\mbcemployee\Form\Assign;

use Drupal\Core\Form\FormStateInterface;

class MBCEmployeeFormAdminAssign extends MBCEmployeeFormManagerAssign
{

    public function getFormId()
    {
        return 1103000;
    }

    public function setRoles()
    {
        $MBCRoleDb = parent::getMBCRoleDb();
        $this->roles = $MBCRoleDb->getAssignableAdminRole();
        $this->level = $MBCRoleDb->getAssignableLevels();
    }

    public function buildFormSpecificElement(array &$form, FormStateInterface $form_state)
    {
        $form['#title'] = $this->t('Assign Administrator');
    }
}