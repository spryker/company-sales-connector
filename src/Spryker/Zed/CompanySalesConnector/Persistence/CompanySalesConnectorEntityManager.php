<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Persistence;

use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\CompanySalesConnector\Persistence\CompanySalesConnectorPersistenceFactory getFactory()
 */
class CompanySalesConnectorEntityManager extends AbstractEntityManager implements CompanySalesConnectorEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function updateOrder(OrderTransfer $orderTransfer): OrderTransfer
    {
        $orderTransfer->requireIdSalesOrder();

        $salesOrderEntity = new SpySalesOrder();
        $salesOrderEntity->fromArray($orderTransfer->toArray());

        $salesOrderEntity->save();

        return $orderTransfer->fromArray(
            $salesOrderEntity->toArray(),
            true
        );
    }
}
