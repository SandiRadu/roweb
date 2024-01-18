<?php
namespace Roweb\Authors\Block;

use Magento\Framework\View\Element\Template\Context;
use Roweb\Authors\Model\AuthorsFactory;
use Magento\Cms\Model\Template\FilterProvider;

/**
 * Authors View block
 */
class AuthorView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Author
     */
    protected $_authors;
    public function __construct(
        Context $context,
        AuthorFactory $authors,
        FilterProvider $filterProvider
    ) {
        $this->_authors = $authors;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Author Page'));

        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $authors = $this->_authors->create();
        $singleData = $authors->load($id);
        if ($singleData->getAuthorId() || $singleData['author_id']) {
            return $singleData;
        } else {
            return false;
        }
    }
}
