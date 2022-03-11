<?php

namespace App\Homepage\Infrastructure\Persistence;

use App\Homepage\Domain\Quote;
use App\Homepage\Domain\QuoteAvatar;
use App\Homepage\Domain\QuoteBy;
use App\Homepage\Domain\QuoteContent;
use App\Homepage\Domain\QuoteRepository;
use App\Shared\Domain\RandomNumberGenerator;

final class InMemoryQuoteRepository implements QuoteRepository
{
    private array $quotes = [
        [
            'quote' => 'When there is no desire, all things are at peace.',
            'by' => 'Laozi',
            'avatar' => 'https://i.imgur.com/hcfQHVk.png',
        ], [
            'quote' => 'Simplicity is the ultimate sophistication.',
            'by' => 'Leonardo da Vinci',
            'avatar' => 'https://i.imgur.com/fk7VpK6.png',
        ], [
            'quote' => 'Smile, breathe, and go slowly.',
            'by' => 'Thich Nhat Hanh',
            'avatar' => 'https://i.imgur.com/5dGaFFm.png',
        ], [
            'quote' => 'Simplicity is an acquired taste.',
            'by' => 'Katharine Gerould',
            'avatar' => 'https://i.imgur.com/kw0NM6i.png',
        ], [
            'quote' => 'Well begun is half done.',
            'by' => 'Aristotle',
            'avatar' => 'https://i.imgur.com/rdA2eXg.jpg',
        ], [
            'quote' => 'He who is contented is rich.',
            'by' => 'Laozi',
            'avatar' => 'https://i.imgur.com/hcfQHVk.png',
        ], [
            'quote' => 'Very little is needed to make a happy life.',
            'by' => 'Marcus Antoninus',
            'avatar' => 'https://i.imgur.com/3pzscGh.png',
        ], [
            'quote' => 'It is quality rather than quantity that matters.',
            'by' => 'Lucius Annaeus Seneca',
            'avatar' => 'https://i.imgur.com/wPZwH3H.png',
        ], [
            'quote' => 'It always seems impossible until it is done.',
            'by' => 'Nelson Mandela',
            'avatar' => 'https://i.imgur.com/o8d2eiJ.png',
        ], [
            'quote' => 'Write it on your heart that every day is the best day in the year.',
            'by' => 'Ralph Waldo Emerson',
            'avatar' => 'https://i.imgur.com/1v1U8O2.jpg',
        ], [
            'quote' => 'Every moment is a fresh beginning.',
            'by' => 'T.S. Eliot',
            'avatar' => 'https://i.imgur.com/AjK9HKF.png',
        ], [
            'quote' => 'Everything you’ve ever wanted is on the other side of fear.',
            'by' => 'George Addair',
            'avatar' => 'https://i.imgur.com/0YdRYJm.png',
        ],
    ];

    public function __construct(private RandomNumberGenerator $randomNumberGenerator)
    {
    }

    public function random(): Quote
    {
        $data = $this->quotes[
            $this->randomNumberGenerator->generate(0, count($this->quotes) - 1)
        ];

        $content = new QuoteContent($data['quote']);
        $by = new QuoteBy($data['by']);
        $avatar = new QuoteAvatar($data['avatar']);

        return new Quote($content, $by, $avatar);
    }
}
