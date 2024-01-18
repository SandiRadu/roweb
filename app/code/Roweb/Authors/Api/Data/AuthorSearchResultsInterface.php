<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Api\Data;

interface AuthorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Author list.
     * @return \Roweb\Authors\Api\Data\AuthorInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Roweb\Authors\Api\Data\AuthorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

