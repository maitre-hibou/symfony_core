<?php

namespace App\Homepage\Domain;

final class Quote
{
    public function __construct(private QuoteContent $content, private QuoteBy $by, private QuoteAvatar $avatar)
    {
    }

    public function content(): QuoteContent
    {
        return $this->content;
    }

    public function by(): QuoteBy
    {
        return $this->by;
    }

    public function avatar(): QuoteAvatar
    {
        return $this->avatar;
    }
}
