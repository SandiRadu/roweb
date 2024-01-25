<?php
declare(strict_types=1);

namespace Roweb\Authors\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Roweb\Authors\Api\AuthorRepositoryInterface;
use Roweb\Authors\Api\Data\AuthorInterface;
use Roweb\Authors\Api\Data\AuthorInterfaceFactory;
use Roweb\Authors\Api\Data\AuthorSearchResultsInterfaceFactory;
use Roweb\Authors\Model\ResourceModel\Author as ResourceAuthor;
use Roweb\Authors\Model\ResourceModel\Author\CollectionFactory as AuthorCollectionFactory;

class AuthorRepository implements AuthorRepositoryInterface
{

    /**
     * @var Author
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var AuthorCollectionFactory
     */
    protected $authorCollectionFactory;

    /**
     * @var ResourceAuthor
     */
    protected $resource;

    /**
     * @var AuthorInterfaceFactory
     */
    protected $authorFactory;


    /**
     * @param ResourceAuthor $resource
     * @param AuthorInterfaceFactory $authorFactory
     * @param AuthorCollectionFactory $authorCollectionFactory
     * @param AuthorSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceAuthor $resource,
        AuthorInterfaceFactory $authorFactory,
        AuthorCollectionFactory $authorCollectionFactory,
        AuthorSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->authorFactory = $authorFactory;
        $this->authorCollectionFactory = $authorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(AuthorInterface $author)
    {
        try {
            $this->resource->save($author);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the author: %1',
                    $exception->getMessage()
                )
            );
        }
        return $author;
    }

    /**
     * @inheritDoc
     */
    public function get($authorId)
    {
        $author = $this->authorFactory->create();
        $this->resource->load($author, $authorId);
        if (!$author->getId()) {
            throw new NoSuchEntityException(__('Author with id "%1" does not exist.', $authorId));
        }
        return $author;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->authorCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(AuthorInterface $author)
    {
        try {
            $authorModel = $this->authorFactory->create();
            $this->resource->load($authorModel, $author->getAuthorId());
            $this->resource->delete($authorModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the Author: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($authorId)
    {
        return $this->delete($this->get($authorId));
    }
}

