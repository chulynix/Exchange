<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/22/16
 * Time: 11:27 AM
 */

namespace Admin\WalletBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class BankDataColumn
 * @package Admin\WalletBundle\Grid\Column
 */
class BankDataColumn extends Column
{
    /**
     * @param array $params
     */
    public function __initialize(array $params)
    {
        parent::__initialize($params);

        // Disable the filter of the column
//        $this->setFilterable(false);
//        $this->setOrder(false);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'bank_data';
    }
}
