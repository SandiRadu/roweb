<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Model\ResourceModel\Author;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'author_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Roweb\Authors\Model\Author::class,
            \Roweb\Authors\Model\ResourceModel\Author::class
        );
    }
}

