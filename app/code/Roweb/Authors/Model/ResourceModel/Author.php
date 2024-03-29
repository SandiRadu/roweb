<?php
declare(strict_types=1);

namespace Roweb\Authors\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Author extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('roweb_authors_author', 'author_id');
    }
}

