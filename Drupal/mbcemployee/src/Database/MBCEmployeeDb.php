<?php

namespace Drupal\mbcemployee\Database;

use Drupal\mbccompany\Database\MBCCompanyDb;

class MBCEmployeeDb extends MBCCompanyDb implements MBCEmployeeDbInterface
{
    /**
     * @param string $input
     * @return mixed
     */
    public function queryAllEmployees($input = '')
    {
        $this->filterString($input);
        $this->selectFields(['id', 'uid', 'default_address', 'default_phone', 'name_first', 'name_last', 'name_middle', 'status']);

        if (!empty($input)) {
            $group = self::$dbSelect->orConditionGroup()
                ->condition('name_last', "%" . self::$dbSelect->escapeLike($input) . "%", 'LIKE')
                ->condition('name_first', "%" . self::$dbSelect->escapeLike($input) . "%", 'LIKE');

            self::$dbSelect->condition($group);
        }

        return self::$dbSelect;
    }

    /**
     * Create an employee entity.
     *
     * @param int $uid, Drupal account UID
     * @param array $employeeInfo
     * @param array $addressInfo
     * @param array $phoneInfo
     * @return int|null, the employee's id is returned if successfully created.
     */
    public function createEmployee(int $uid, array &$employeeInfo, array &$addressInfo, array &$phoneInfo)
    {
        $employeeInfo['address'] = $addressInfo;
        $employeeInfo['phone'] = $phoneInfo;

        return $this->update($employeeInfo);
    }

    /**
     * @param array $officeIds
     * @param array $tableHeader
     * @param string $input
     * @return mixed
     */
    public function searchEmployee(array $officeIds, array &$tableHeader, $input = '')
    {
        self::$dbSelect->fields('base', ['id', 'default_address', 'default_phone', 'name', 'industry', 'status']);
        self::$dbSelect->condition('c.owner', $officeIds, 'IN');

        if ($input) {
            self::$dbSelect->condition('name', "%" . $query->escapeLike($input) . "%", 'LIKE');
        }
        self::$dbSelect->addField('a', 'zip_code');
        self::$dbSelect->leftJoin('mbc_company_address', 'a', 'c.default_address = a.id');
        self::$dbSelect->fields('a');
        self::$dbSelect->addField('p', 'phone_area_code');
        self::$dbSelect->leftJoin('mbc_company_phone', 'p', 'c.default_phone = p.id');
        self::$dbSelect->fields('p');

        $table_sort = $query->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($tableHeader);
        $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(5);
        $res = $pager->execute()->fetchAll(\PDO::FETCH_ASSOC);

        return $res;
    }
}

