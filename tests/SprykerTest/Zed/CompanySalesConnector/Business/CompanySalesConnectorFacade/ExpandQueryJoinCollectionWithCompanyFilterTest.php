<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\CompanySalesConnector\Business\CompanySalesConnectorFacade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Generated\Shared\Transfer\QueryJoinCollectionTransfer;
use Spryker\Zed\CompanySalesConnector\Business\Expander\OrderSearchQueryExpander;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group CompanySalesConnector
 * @group Business
 * @group CompanySalesConnectorFacade
 * @group ExpandQueryJoinCollectionWithCompanyFilterTest
 * Add your own group annotations below this line
 */
class ExpandQueryJoinCollectionWithCompanyFilterTest extends Unit
{
    /**
     * @uses OrderSearchQueryExpander::COLUMN_COMPANY_UUID
     */
    protected const COLUMN_COMPANY_UUID = 'company_uuid';

    /**
     * @uses OrderSearchQueryExpander::COMPARISON_EQUAL
     */
    protected const COMPARISON_EQUAL = '=';

    protected const UUID_SAMPLE = 'uuid-sample';

    /**
     * @var \SprykerTest\Zed\CompanySalesConnector\CompanySalesConnectorBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExpandQueryJoinCollectionWithCompanyBusinessUnitFilterExpandsCollection(): void
    {
        // Arrange
        $queryJoinCollectionTransfer = new QueryJoinCollectionTransfer();

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(OrderSearchQueryExpander::FILTER_FIELD_TYPE_COMPANY)
            ->setValue(static::UUID_SAMPLE);

        // Act
        $queryJoinCollectionTransfer = $this->tester->getFacade()->expandQueryJoinCollectionWithCompanyFilter(
            [$filterFieldTransfer],
            $queryJoinCollectionTransfer
        );

        // Assert
        $this->assertCount(1, $queryJoinCollectionTransfer->getQueryJoins());

        /**
         * @var \Generated\Shared\Transfer\QueryJoinTransfer $queryJoinTransfer
         */
        $queryJoinTransfer = $queryJoinCollectionTransfer->getQueryJoins()->getIterator()->current();

        $this->assertCount(1, $queryJoinTransfer->getQueryWhereConditions());

        /**
         * @var \Generated\Shared\Transfer\QueryWhereConditionTransfer $queryWhereConditionTransfer
         */
        $queryWhereConditionTransfer = $queryJoinTransfer->getQueryWhereConditions()->getIterator()->current();

        $this->assertSame(static::UUID_SAMPLE, $queryWhereConditionTransfer->getValue());
        $this->assertSame(static::COLUMN_COMPANY_UUID, $queryWhereConditionTransfer->getColumn());
        $this->assertSame(static::COMPARISON_EQUAL, $queryWhereConditionTransfer->getComparison());
    }

    /**
     * @return void
     */
    public function testExpandQueryJoinCollectionWithCompanyBusinessUnitFilterIgnoresIrrelevantFilterFields(): void
    {
        // Arrange
        $queryJoinCollectionTransfer = new QueryJoinCollectionTransfer();

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType('fake')
            ->setValue(static::UUID_SAMPLE);

        // Act
        $queryJoinCollectionTransfer = $this->tester->getFacade()->expandQueryJoinCollectionWithCompanyFilter(
            [$filterFieldTransfer],
            $queryJoinCollectionTransfer
        );
        // Assert
        $this->assertCount(0, $queryJoinCollectionTransfer->getQueryJoins());
    }
}
