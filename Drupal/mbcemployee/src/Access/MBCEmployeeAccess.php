<?php

namespace Drupal\mbcemployee\Access;

use Drupal\mbccompany\Access\MBCCompanyAccess;

class MBCEmployeeAccess extends MBCCompanyAccess
{
    /**
     * @param string $mbc_type_id
     * @param string $mbc_id
     * @return false|array
     */
    public function accessViewEmployeeList($mbc_type_id = '', $mbc_id = '')
    {
        return $this->MBCFls->validateNode($mbc_type_id, $mbc_id);
    }
}