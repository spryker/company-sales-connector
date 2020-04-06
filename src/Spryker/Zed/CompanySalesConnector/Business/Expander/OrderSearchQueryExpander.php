<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanySalesConnector\Business\Expander;

use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Generated\Shared\Transfer\QueryWhereConditionTransfer;
use Spryker\Zed\CompanySalesConnector\CompanySalesConnectorConfig;

class OrderSearchQueryExpander implements OrderSearchQueryExpanderInterface
{
    /**
     * @uses \Spryker\Zed\Sales\Persistence\Propel\QueryBuilder\OrderSearchFilterFieldQueryBuilder::CONDITION_GROUP_ALL
     */
    protected const CONDITION_GROUP_ALL = 'CONDITION_GROUP_ALL';

    protected const MAPPED_ORDER_BY_FILTERS = [
        'customerName' => self::COLUMN_FULL_NAME,
        'customerEmail' => self::COLUMN_EMAIL,
    ];

    protected const COLUMN_FULL_NAME = 'full_name';

    /**
     * @see \Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap::COL_FIRST_NAME
     */
    protected const COLUMN_FIRST_NAME = 'first_name';

    /**
     * @see \Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap::COL_FIRST_NAME
     */
    protected const COLUMN_LAST_NAME = 'last_name';

    /**
     * @see \Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap::COL_COMPANY_UUID
     */
    protected const COLUMN_COMPANY_UUID = 'company_uuid';

    /**
     * @see \Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap::COL_EMAIL
     */
    protected const COLUMN_EMAIL = 'email';

    /**
     * @see \Propel\Runtime\ActiveQuery\Criteria::EQUAL
     */
    protected const COMPARISON_EQUAL = '=';

    /**
     * @uses \Spryker\Zed\Sales\Persistence\Propel\QueryBuilder\OrderSearchFilterFieldQueryBuilder::DELIMITER_ORDER_BY
     */
    protected const DELIMITER_ORDER_BY = '::';

    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCompanyFilter(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        $filterFieldTransfer = $this->extractFilterFieldByType($filterFieldTransfers, CompanySalesConnectorConfig::FILTER_FIELD_TYPE_COMPANY);

        if (!$filterFieldTransfer) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            $this->createCompanyFilterQueryJoin($filterFieldTransfer->getValue())
        );
    }

    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCustomerFilter(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        $filterFieldTransfer = $this->extractFilterFieldByType(
            $filterFieldTransfers,
            CompanySalesConnectorConfig::FILTER_FIELD_TYPE_ALL
        );

        if (!$filterFieldTransfer) {
            return $queryJoinCollectionTransfer;
        }

        $queryJoinCollectionTransfer->addQueryJoin(
            $this->createCustomerFilterQueryJoin($filterFieldTransfer->getValue())
        );

        return $queryJoinCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param \Generated\Shared\Transfer\QueryJoinCollectionTransfer $queryJoinCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\QueryJoinCollectionTransfer
     */
    public function expandQueryJoinCollectionWithCustomerSorting(
        array $filterFieldTransfers,
        QueryJoinCollectionTransfer $queryJoinCollectionTransfer
    ): QueryJoinCollectionTransfer {
        $filterFieldTransfer = $this->extractFilterFieldByType(
            $filterFieldTransfers,
            CompanySalesConnectorConfig::FILTER_FIELD_TYPE_ORDER_BY
        );

        if (!$filterFieldTransfer) {
            return $queryJoinCollectionTransfer;
        }

        $mappedOrderByFilters = array_keys(static::MAPPED_ORDER_BY_FILTERS);
        [$orderColumn, $orderDirection] = explode(static::DELIMITER_ORDER_BY, $filterFieldTransfer->getValue());

        if (!in_array($orderColumn, $mappedOrderByFilters, true) || !$orderDirection) {
            return $queryJoinCollectionTransfer;
        }

        return $queryJoinCollectionTransfer->addQueryJoin(
            $this->createCustomerSortingQueryJoin($orderColumn, $orderDirection)
        );
    }

    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param string $type
     *
     * @return bool
     */
    public function isFilterFieldSet(array $filterFieldTransfers, string $type): bool
    {
        return $this->extractFilterFieldByType($filterFieldTransfers, $type) !== null;
    }

    /**
     * @param \Generated\Shared\Transfer\FilterFieldTransfer[] $filterFieldTransfers
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\FilterFieldTransfer|null
     */
    protected function extractFilterFieldByType(array $filterFieldTransfers, string $type): ?FilterFieldTransfer
    {
        foreach ($filterFieldTransfers as $filterFieldTransfer) {
            if ($filterFieldTransfer->getType() === $type) {
                return $filterFieldTransfer;
            }
        }

        return null;
    }

    /**
     * @param string $companyUuid
     *
     * @return \Generated\Shared\Transfer\QueryJoinTransfer
     */
    protected function createCompanyFilterQueryJoin(string $companyUuid): QueryJoinTransfer
    {
        $queryWhereConditionTransfer = (new QueryWhereConditionTransfer())
            ->setColumn(static::COLUMN_COMPANY_UUID)
            ->setValue($companyUuid)
            ->setComparison(static::COMPARISON_EQUAL);

        return (new QueryJoinTransfer())->addQueryWhereCondition($queryWhereConditionTransfer);
    }

    /**
     * @param string $searchString
     *
     * @return \Generated\Shared\Transfer\QueryJoinTransfer
     */
    protected function createCustomerFilterQueryJoin(string $searchString): QueryJoinTransfer
    {
        $queryJoinTransfer = new QueryJoinTransfer();
        $fullNameColumn = $this->getConcatenatedFullNameColumn();

        $queryWhereConditionTransfer = (new QueryWhereConditionTransfer())
            ->setMergeWithCondition(static::CONDITION_GROUP_ALL)
            ->setColumn($fullNameColumn)
            ->setValue($searchString);

        $queryJoinTransfer->addQueryWhereCondition($queryWhereConditionTransfer);

        $queryWhereConditionTransfer = (new QueryWhereConditionTransfer())
            ->setMergeWithCondition(static::CONDITION_GROUP_ALL)
            ->setColumn(static::COLUMN_EMAIL)
            ->setValue($searchString);

        $queryJoinTransfer->addQueryWhereCondition($queryWhereConditionTransfer);

        return $queryJoinTransfer->setWithColumns([static::COLUMN_FULL_NAME => $fullNameColumn]);
    }

    /**
     * @param string $orderBy
     * @param string $orderDirection
     *
     * @return \Generated\Shared\Transfer\QueryJoinTransfer
     */
    protected function createCustomerSortingQueryJoin(string $orderBy, string $orderDirection): QueryJoinTransfer
    {
        return (new QueryJoinTransfer())
            ->setWithColumns([static::COLUMN_FULL_NAME => $this->getConcatenatedFullNameColumn()])
            ->setOrderBy(static::MAPPED_ORDER_BY_FILTERS[$orderBy])
            ->setOrderDirection($orderDirection);
    }

    /**
     * @return string
     */
    protected function getConcatenatedFullNameColumn(): string
    {
        return sprintf('CONCAT(%s,\' \', %s)', static::COLUMN_FIRST_NAME, static::COLUMN_LAST_NAME);
    }
}
