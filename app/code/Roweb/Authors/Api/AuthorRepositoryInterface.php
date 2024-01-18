<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface AuthorRepositoryInterface
{

    /**
     * Save Author
     * @param \Roweb\Authors\Api\Data\AuthorInterface $author
     * @return \Roweb\Authors\Api\Data\AuthorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Roweb\Authors\Api\Data\AuthorInterface $author
    );

    /**
     * Retrieve Author
     * @param string $authorId
     * @return \Roweb\Authors\Api\Data\AuthorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($authorId);

    /**
     * Retrieve Author matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Roweb\Authors\Api\Data\AuthorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Author
     * @param \Roweb\Authors\Api\Data\AuthorInterface $author
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Roweb\Authors\Api\Data\AuthorInterface $author
    );

    /**
     * Delete Author by ID
     * @param string $authorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($authorId);
}

