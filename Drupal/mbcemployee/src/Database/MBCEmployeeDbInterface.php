<?php

namespace Drupal\mbcemployee\Database;

use Drupal\mbccompany\Database\MBCCompanyDbInterface;

interface MBCEmployeeDbInterface extends MBCCompanyDbInterface
{
    public function queryAllEmployees($input = '');

    public function createEmployee($uid, array &$employeeInfo, array &$addressInfo, array &$phoneInfo);

    public function searchEmployee(array $officeIds, array &$tableHeader, $input = '');
}