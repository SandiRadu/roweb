<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Controller\Adminhtml\Author;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Roweb\Authors\Controller\Adminhtml\Author
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

            // start upload image
            // if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            //     try {
            //         $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
            //         $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            //         $imageAdapter = $this->adapterFactory->create();
            //         $uploaderFactory->addValidateCallback('custom_image_upload', $imageAdapter, 'validateUploadFile');
            //         $uploaderFactory->setAllowRenameFiles(true);
            //         $uploaderFactory->setFilesDispersion(true);
            //         $mediaDirectory = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA);
            //         $destinationPath = $mediaDirectory->getAbsolutePath('roweb/authors');
            //         $result = $uploaderFactory->save($destinationPath);
            //         if (!$result) {
            //             throw new LocalizedException(
            //                 __('File cannot be saved to path: $1', $destinationPath)
            //             );
            //         }

            //         $imagePath = 'roweb/authors' . $result['file'];
            //         $data['image'] = $imagePath;
            //     } catch (\Exception $e) {
            //     }
            // }

            // if (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
            //     $mediaDirectory = $this->filesystem->getDirectoryRead($this->directoryList::MEDIA)->getAbsolutePath();
            //     $file = $data['image']['value'];
            //     $imgPath = $mediaDirectory . $file;
            //     if ($this->_file->isExists($imgPath)) {
            //         $this->_file->deleteFile($imgPath);
            //     }
            //     $data['image'] = NULL;
            // }
            // if (isset($data['image']['value'])) {
            //     $data['image'] = $data['image']['value'];
            // }
            // $inputFilter = new \Zend_Filter_Input(
            //     [],
            //     [],
            //     $data
            // );
            // $data = $inputFilter->getUnescaped();

            // end upload image

            $id = $this->getRequest()->getParam('author_id');

            $model = $this->_objectManager->create(\Roweb\Authors\Model\Author::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Author no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

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

