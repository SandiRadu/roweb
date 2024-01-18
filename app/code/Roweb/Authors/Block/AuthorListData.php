<?php

declare(strict_types=1);

namespace Roweb\Authors\Block;

use Magento\Framework\View\Element\Template\Context;
use Roweb\Authors\Model\AuthorFactory;

/**
 * Authors List block
 */
class AuthorListData extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Author
     */
    protected $_authors;

    public function __construct(
        Context $context,
        AuthorFactory $authors
    ) {
        $this->_authors = $authors;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Authors List Page'));

        if ($this->getAuthorsCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'roweb.authors.pager'
            )->setAvailableLimit(array(5 => 5, 10 => 10, 15 => 15))->setShowPerPage(true)->setCollection(
                    $this->getAuthorsCollection()
                );
            $this->setChild('pager', $pager);
            $this->getAuthorsCollection()->load();
        }
        return parent::_prepareLayout();
    }

    public function getAuthorsCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;

        $authors = $this->_authors->create();

        $collection = $authors->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        return $collection;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
