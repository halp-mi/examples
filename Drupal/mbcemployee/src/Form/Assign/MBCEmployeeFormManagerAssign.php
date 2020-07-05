<?php

namespace Drupal\mbcemployee\Form\Assign;

use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MBCEmployeeFormManagerAssign extends MBCEmployeeFormRoleAssign
{

    protected $assignableLevels;

    protected $actions = [
        0 => 'Disable Role',
        1 => 'Enable Role'
    ];

    public function getFormId()
    {
        return 1102500;
    }

    public function getTableActions()
    {
        return [
            'level' => $this->getAssignableLevels(),
            'role' => $this->getAssignableRoles(),
            'action' => $this->actions
        ];
    }

    protected function getAssignableLevels()
    {
        if (!$this->assignableLevels) {
            $this->assignableLevels = $this->getMBCRoleDb()->getAssignableLevels();
        }

        return $this->assignableLevels;
    }

    protected function getAssignableRoles()
    {
        if (!$this->roles) {
            $this->roles = $this->getMBCRoleDb()->getAssignableManagerRole();
        }

        return $this->roles;
    }

    public function buildFormSpecificElement(array &$form, FormStateInterface $form_state)
    {
        $form['#title'] = $this->t('Assign Manager');
    }

    public function saveFormData(array &$form, FormStateInterface $form_state)
    {

        $action = $form_state->getValue('select-action');
        $ids = array_filter($form_state->getValue('table-result'));
        $this->getMBCRoleDb->update(ids, $action, $roles);
    }
}