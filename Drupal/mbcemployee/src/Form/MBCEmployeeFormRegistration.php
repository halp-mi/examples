<?php

namespace Drupal\mbcemployee\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\mbccommon\Form\MBCCommonFormRegistrationBase;

class MBCEmployeeFormRegistration extends MBCCommonFormRegistrationBase
{

    /** @var  \Drupal\mbcemployee\Database\MBCEmployeeDbInterface */
    private $MBCEmployeeDb;

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return mixed
     */
    public static function callbackTableResult(array &$form, FormStateInterface $form_state)
    {
        drupal_get_messages();
        return $form['#ptr_company_id'];
    }

    /**
     * @return int
     */
    public function getFormId()
    {
        return 1101000;
    }

    /**
     * @return array[]|null
     */
    public function configuration()
    {
        if ($this->formInfo === null) {

            $formConfigPath = parent::getMBCFilePath();

            $this->formInfo = [
                1101000 => [
                    '#name' => 'employee',
                    '#tbl' => 'mbc_employee_employee',
                    '#filepath' => $formConfigPath->getFilePath('employee'),
                ],
                1051500 => [
                    '#name' => 'phone',
                    '#tbl' => 'mbc_employee_phone',
                    '#filepath' => $formConfigPath->getFilePath('phone'),
                ],
                1052000 => [
                    '#name' => 'address',
                    '#tbl' => 'mbc_employee_address',
                    '#filepath' => $formConfigPath->getFilePath('address'),
                ],
                1004000 => [
                    '#name' => 'account',
                    '#filepath' => $formConfigPath->getFilePath('account'),
                ],
            ];
        }

        return $this->formInfo;
    }

    public function buildFormSpecificElement(array &$form, FormStateInterface $form_state)
    {
        $form['#title'] = $this->t('User Registration');

        $form['root_container']['container_submit']['confirm'] = [
            '#type' => 'checkbox',
            '#title' => $this->t('I Agree'),
            '#description' => $this->t('<span class="mbc-req"/>By checking this box you agree to adhere to all the terms and conditions.'),
            '#required' => TRUE,
        ];

        $this->disableCache();
    }

    public function validateOnSubmit(array &$form, FormStateInterface $form_state)
    {
        $this->validateEmail($form, $form_state);
        $this->validateUsername($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $triggerElementName = $form_state->getTriggeringElement()['#name'];

        if ($triggerElementName === 'btn_filter') {

            if ($search = $form_state->getValue('search')) {
                $buildInfo['search'] = $search;
                $form_state->setRebuildInfo($buildInfo);
            }

            $form_state->setRebuild(TRUE);
        } else {
            parent::submitForm($form, $form_state);
        }
    }

    public function saveFormData(array &$form, FormStateInterface $form_state)
    {
        $values = parent::getAllValues();

        $accountInfo = $values['account'];
        $employeeInfo = $values['employee'];
        $phoneData = $values['phone'];
        $addressData = $values['address'];

        $uid = mbccommon_create_account($accountInfo);

        $this->getMBCEmployeeDb()
            ->createEmployee($uid, $employeeInfo, $addressInfo, $phoneInfo);

        $MBCCommonActivate = \Drupal::service('mbccommon.activation');

        $MBCCommonActivate
            ->createActivationCode($uid, $phoneData)
            ->sendActivationCode();

        drupal_set_message($this->t('User account successfully created. Please check your email or text to activate your account.'));
        $form_state->setRedirect('mbccommon.register.activate');
  }

    public function getMBCEmployeeDb()
    {
        if (!$this->MBCEmployeeDb) {
            $this->MBCEmployeeDb = \Drupal::service('mbcemployee.db.employee');
        }

        return $this->MBCEmployeeDb;
    }

}