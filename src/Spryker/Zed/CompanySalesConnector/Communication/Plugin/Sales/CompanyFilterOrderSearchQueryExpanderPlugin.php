<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Communication\Plugin\Sales;

use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderSearchQueryExpanderPluginInterface;

/**
 * @method \Spryker\Zed\CompanySalesConnector\Business\CompanySalesConnectorFacadeInterface getFacade()
 */
class CompanyFilterOrderSearchQueryExpanderPlugin extends AbstractPlugin implements OrderSearchQueryExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Returns true if filtering by company could be applied, false otherwise.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return bool
     */
    public function isApplicable(OrderListTransfer $orderListTransfer): bool
    {
        return $this->getFacade()->isCompanyFilterApplicable(
            $orderListTransfer->getFilterFields()->getArrayCopy()
        );
    }

    /**
     * {@inheritDoc}
     * - Expands OrderListTransfer::queryJoins with additional QueryJoinTransfer to filter by company.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function expand(OrderListTransfer $orderListTransfer): OrderListTransfer
    {
        $queryJoinCollectionTransfer = $this->getFacade()->expandQueryJoinCollectionWithCompanyFilter(
            $orderListTransfer->getFilterFields()->getArrayCopy(),
            $orderListTransfer->getQueryJoins()
        );

        return $orderListTransfer->setQueryJoins($queryJoinCollectionTransfer);
    }
}
