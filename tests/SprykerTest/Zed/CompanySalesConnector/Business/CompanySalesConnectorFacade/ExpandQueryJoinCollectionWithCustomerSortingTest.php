<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CompanySalesConnector\Business\CompanySalesConnectorFacade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Generated\Shared\Transfer\QueryJoinTransfer;
use Spryker\Zed\CompanySalesConnector\CompanySalesConnectorConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CompanySalesConnector
 * @group Business
 * @group CompanySalesConnectorFacade
 * @group ExpandQueryJoinCollectionWithCustomerSortingTest
 * Add your own group annotations below this line
 */
class ExpandQueryJoinCollectionWithCustomerSortingTest extends Unit
{
    /**
     * @uses \Spryker\Zed\CompanySalesConnector\Business\Expander\OrderSearchQueryExpander::COLUMN_EMAIL
     *
     * @var string
     */
    protected const COLUMN_EMAIL = 'spy_sales_order.email';

    /**
     * @uses \Spryker\Zed\CompanySalesConnector\Business\Expander\OrderSearchQueryExpander::COLUMN_FULL_NAME
     *
     * @var string
     */
    protected const COLUMN_FULL_NAME = 'full_name';

    /**
     * @see \Spryker\Zed\CompanySalesConnector\Business\Expander\OrderSearchQueryExpander::getConcatenatedFullNameColumn()
     *
     * @var string
     */
    protected const COLUMN_FULL_NAME_EXPRESSION = 'CONCAT(first_name,\' \', last_name)';

    /**
     * @var \SprykerTest\Zed\CompanySalesConnector\CompanySalesConnectorBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExpandQueryJoinCollectionWithCustomerSortingExpandsCollectionForCustomerEmail(): void
    {
        // Arrange
        $queryJoinCollectionTransfer = new QueryJoinCollectionTransfer();

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(CompanySalesConnectorConfig::FILTER_FIELD_TYPE_ORDER_BY)
            ->setValue('customerEmail::ASC');

        // Act
        $queryJoinCollectionTransfer = $this->tester->getFacade()->expandQueryJoinCollectionWithCustomerSorting(
            [$filterFieldTransfer],
            $queryJoinCollectionTransfer,
        );

        // Assert
        $this->assertCount(1, $queryJoinCollectionTransfer->getQueryJoins());

        $queryJoinTransfer = $queryJoinCollectionTransfer->getQueryJoins()->getIterator()->current();

        $this->assertQueryJoinTransfer($queryJoinTransfer, static::COLUMN_EMAIL, 'ASC');
    }

    /**
     * @return void
     */
    public function testExpandQueryJoinCollectionWithCustomerSortingExpandsCollectionForCustomerName(): void
    {
        // Arrange
        $queryJoinCollectionTransfer = new QueryJoinCollectionTransfer();

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(CompanySalesConnectorConfig::FILTER_FIELD_TYPE_ORDER_BY)
            ->setValue('customerName::DESC');

        // Act
        $queryJoinCollectionTransfer = $this->tester->getFacade()->expandQueryJoinCollectionWithCustomerSorting(
            [$filterFieldTransfer],
            $queryJoinCollectionTransfer,
        );

        // Assert
        $this->assertCount(1, $queryJoinCollectionTransfer->getQueryJoins());

        $queryJoinTransfer = $queryJoinCollectionTransfer->getQueryJoins()->getIterator()->current();

        $this->assertQueryJoinTransfer($queryJoinTransfer, static::COLUMN_FULL_NAME, 'DESC');
    }

    /**
     * @return void
     */
    public function testExpandQueryJoinCollectionWithCustomerSortingIgnoresIrrelevantFilterFields(): void
    {
        // Arrange
        $queryJoinCollectionTransfer = new QueryJoinCollectionTransfer();

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(CompanySalesConnectorConfig::FILTER_FIELD_TYPE_ORDER_BY)
            ->setValue('sample::ASC');

        // Act
        $queryJoinCollectionTransfer = $this->tester->getFacade()->expandQueryJoinCollectionWithCustomerSorting(
            [$filterFieldTransfer],
            $queryJoinCollectionTransfer,
        );

        // Assert
        $this->assertCount(0, $queryJoinCollectionTransfer->getQueryJoins());
    }

    /**
     * @param \Generated\Shared\Transfer\QueryJoinTransfer $queryJoinTransfer
     * @param string $expectedOrderBy
     * @param string $expectedOrderDirection
     *
     * @return void
     */
    protected function assertQueryJoinTransfer(
        QueryJoinTransfer $queryJoinTransfer,
        string $expectedOrderBy,
        string $expectedOrderDirection
    ): void {
        $this->assertSame([static::COLUMN_FULL_NAME => static::COLUMN_FULL_NAME_EXPRESSION], $queryJoinTransfer->getWithColumns());
        $this->assertSame($expectedOrderBy, $queryJoinTransfer->getOrderBy());
        $this->assertSame($expectedOrderDirection, $queryJoinTransfer->getOrderDirection());
    }
}
