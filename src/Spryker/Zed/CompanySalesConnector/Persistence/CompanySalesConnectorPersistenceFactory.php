<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Persistence;

use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\CompanySalesConnector\CompanySalesConnectorDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Spryker\Zed\CompanySalesConnector\Persistence\CompanySalesConnectorEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CompanySalesConnector\Persistence\CompanySalesConnectorRepositoryInterface getRepository()
 * @method \Spryker\Zed\CompanySalesConnector\CompanySalesConnectorConfig getConfig()
 */
class CompanySalesConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function getSalesOrderPropelQuery(): SpySalesOrderQuery
    {
        return $this->getProvidedDependency(CompanySalesConnectorDependencyProvider::PROPEL_QUERY_SALES_ORDER);
    }
}
