<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Communication\Plugin\Sales;

use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Spryker\Zed\CompanySalesConnector\Business\Expander\OrderSearchQueryExpander;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderSearchQueryExpanderPluginInterface;

/**
 * @method \Spryker\Zed\CompanySalesConnector\Business\CompanySalesConnectorFacadeInterface getFacade()
 * @method \Spryker\Zed\CompanySalesConnector\CompanySalesConnectorConfig getConfig()
 */
class CompanyFilterOrderSearchQueryExpanderPlugin extends AbstractPlugin implements OrderSearchQueryExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Returns true if filtering by company could be applied, false otherwise.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     *
     * @return bool
     */
    public function isApplicable(array $filterFieldTransfers): bool
    {
        return $this->getFacade()->isFilterFieldSet(
            $filterFieldTransfers,
            OrderSearchQueryExpander::FILTER_FIELD_TYPE_COMPANY
        );
    }

    /**
     * {@inheritDoc}
     * - Expands QueryJoinCollectionTransfer with additional QueryJoinTransfer to filter by company.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expand(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        return $this->getFacade()->expandQueryJoinCollectionWithCompanyFilter(
            $filterFieldTransfers,
            $queryJoinCollectionTransfer
        );
    }
}
