<?php
declare(strict_types=1);

namespace Roweb\Authors\Controller\Adminhtml\Author;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            $id = $this->getRequest()->getParam('author_id');

            $model = $this->_objectManager->create(\Roweb\Authors\Model\Author::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Author no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            // if (!empty($data['feature_image'][0]['name'] && isset($data['feature_image'][0]['temp_name']))) {
            //     $data['feature_image'] = $data['feature_image'][0]['name']; 
            // } else {
            //     unset($data['feature_image']);
            // }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Author.'));
                $this->dataPersistor->clear('roweb_authors_author');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['author_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Author.'));
            }

            $this->dataPersistor->set('roweb_authors_author', $data);
            return $resultRedirect->setPath('*/*/edit', ['author_id' => $this->getRequest()->getParam('author_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}