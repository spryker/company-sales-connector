<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanySalesConnectorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const FILTER_FIELD_TYPE_COMPANY = 'company';

    /**
     * @uses \Spryker\Zed\Sales\Persistence\Propel\QueryBuilder\OrderSearchFilterFieldQueryBuilder::SEARCH_TYPE_ALL
     *
     * @var string
     */
    public const FILTER_FIELD_TYPE_ALL = 'all';

    /**
     * @uses \Spryker\Zed\Sales\Persistence\Propel\QueryBuilder\OrderSearchFilterFieldQueryBuilder::FILTER_FIELD_TYPE_ORDER_BY
     *
     * @var string
     */
    public const FILTER_FIELD_TYPE_ORDER_BY = 'orderBy';
}
