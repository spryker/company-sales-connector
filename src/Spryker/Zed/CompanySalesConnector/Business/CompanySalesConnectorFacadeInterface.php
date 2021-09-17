<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface CompanySalesConnectorFacadeInterface
{
    /**
     * Specification:
     * - Requires SaveOrderTransfer::idSalesOrder to be set.
     * - Executes only if QuoteTransfer::customer::companyUser::company::uuid is provided.
     * - Expands sales order with company uuid and persists updated entity.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function updateOrderCompanyUuid(SaveOrderTransfer $saveOrderTransfer, QuoteTransfer $quoteTransfer): void;

    /**
     * Specification:
     * - Expands QueryJoinCollectionTransfer with additional QueryJoinTransfer to filter by company.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCompanyFilter(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer;

    /**
     * Specification:
     * - Expands QueryJoinCollectionTransfer with additional QueryJoinTransfers to filter by customer name and email.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCustomerFilter(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer;

    /**
     * Specification:
     * - Expands QueryJoinCollectionTransfer with additional QueryJoinTransfers to sort by customer name or email.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCustomerSorting(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer;

    /**
     * Specification:
     * - Returns true if filter with specific type set, false otherwise.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     * @param string $type
     *
     * @return bool
     */
    public function isFilterFieldSet(array $filterFieldTransfers, string $type): bool;

    /**
     * Specification:
     * - Checks SeeCompanyOrdersPermissionPlugin for customer who retrieves customer order.
     * - Returns true if customer has SeeCompanyOrdersPermissionPlugin, false otherwise.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function checkOrderAccessByCustomerCompany(OrderTransfer $orderTransfer, CustomerTransfer $customerTransfer): bool;
}
