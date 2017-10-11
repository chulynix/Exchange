<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/6/16
 * Time: 11:50 AM
 */

namespace OfficeBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class TransactionStatusColumn
 * @package OfficeBundle\Grid\Column
 */
class TransactionStatusColumn extends Column
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'status_transaction';
    }
}
