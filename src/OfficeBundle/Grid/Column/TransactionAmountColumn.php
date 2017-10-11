<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/6/16
 * Time: 12:22 PM
 */

namespace OfficeBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class TransactionAmountColumn
 * @package OfficeBundle\Grid\Column
 */
class TransactionAmountColumn extends Column
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'amount_transaction';
    }
}
