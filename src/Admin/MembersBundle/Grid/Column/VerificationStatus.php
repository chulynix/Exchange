<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/9/16
 * Time: 3:45 PM
 */

namespace Admin\MembersBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class VerificationStatus
 * @package Admin\MembersBundle\Grid\Column
 */
class VerificationStatus extends Column
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
        return 'verification_status';
    }
}
