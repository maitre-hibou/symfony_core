<?php

namespace App\Homepage\Domain;

interface QuoteRepository
{
    public function random(): Quote;
}
