<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Roweb\Authors\Api\Data;

interface AuthorInterface
{

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const AUTHOR_ID = 'author_id';

    const IMAGE = 'image';

    /**
     * Get author_id
     * @return string|null
     */
    public function getAuthorId();

    /**
     * Set author_id
     * @param string $authorId
     * @return \Roweb\Authors\Author\Api\Data\AuthorInterface
     */
    public function setAuthorId($authorId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Roweb\Authors\Author\Api\Data\AuthorInterface
     */
    public function setName($name);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Roweb\Authors\Author\Api\Data\AuthorInterface
     */
    public function setDescription($description);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Roweb\Authors\Author\Api\Data\AuthorInterface
     */
    public function setImage($image);

}

