<?php

namespace App\Blog\Post\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Timestamps;

final class Post extends AggregateRoot
{
    public function __construct(
        private PostId $id,
        private PostTitle $title,
        private PostContent $content,
        private PostSlug $slug,
        private PostMetaTitle $metaTitle,
        private PostMetaDescription $metaDescription,
        private Timestamps $timestamps,
        ) {
    }

    public static function create(
        PostId $id,
        PostTitle $title,
        PostContent $content,
        PostSlug $slug,
        PostMetaTitle $metaTitle,
        PostMetaDescription $metaDescription
    ) {
        $now = new \DateTime();

        return new self($id, $title, $content, $slug, $metaTitle, $metaDescription, new Timestamps($now, $now));
    }

    public function id(): PostId
    {
        return $this->id;
    }

    public function title(): PostTitle
    {
        return $this->title;
    }

    public function content(): PostContent
    {
        return $this->content;
    }

    public function slug(): PostSlug
    {
        return $this->slug;
    }

    public function metaTitle(): PostMetaTitle
    {
        return $this->metaTitle;
    }

    public function metaDescription(): PostMetaDescription
    {
        return $this->metaDescription;
    }
}
