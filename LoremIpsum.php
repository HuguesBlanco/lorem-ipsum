<?php

/**
 * Class to create lorem ipsum text
 * @author Hugues Blanco Alvarez <contact@huguesblanco.com>
 */

declare(strict_types = 1);

namespace Emailfabrik;

use UnexpectedValueException;

class LoremIpsum
{
    /**
     * The words to create the lorem ipsum.
     */
    private array $words = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'sed', 'non', 'risus', 'suspendisse', 'lectus', 'tortor', 'dignissim', 'nec', 'ultricies', 'cras', 'elementum', 'ultrices', 'diam', 'maecenas', 'ligula', 'massa', 'varius', 'a', 'semper', 'congue', 'euismod', 'mi', 'proin', 'porttitor', 'orci', 'nonummy', 'molestie', 'enim', 'est', 'eleifend', 'fermentum', 'nisl', 'erat', 'duis', 'arcu', 'scelerisque', 'vitae', 'consequat', 'in', 'pretium', 'pellentesque', 'ut', 'volutpat', 'libero', 'pharetra', 'tempor', 'vestibulum', 'bibendum', 'augue', 'praesent', 'egestas', 'leo', 'pede', 'blandit', 'odio', 'eu', 'dui', 'sodales', 'ante', 'primis', 'faucibus', 'luctus', 'et', 'posuere', 'cubilia', 'curae', 'aliquam', 'nibh', 'mauris', 'ac', 'hendrerit', 'velit', 'gravida', 'ornare', 'aenean', 'vel', 'suscipit', 'pulvinar', 'nulla', 'sollicitudin', 'fusce', 'tempus', 'nunc', 'turpis', 'ullamcorper', 'sapien', 'eros', 'rhoncus', 'integer', 'id', 'felis', 'curabitur', 'aliquet', 'quis', 'metus', 'lobortis', 'consectetuer', 'morbi', 'convallis', 'vehicula', 'tellus', 'quam', 'feugiat', 'purus', 'iaculis', 'tristique', 'justo', 'magna', 'at', 'mollis', 'vulputate', 'sem', 'vivamus', 'placerat', 'imperdiet', 'cursus', 'rutrum', 'tincidunt', 'lacus'
    ];

    /**
     * Give you some words.
     *
     * @param integer $nbr     The number of words you want.
     * @param boolean $UCFirst True (default) if you want the first word starts with an uppercase. False otherwise.
     * 
     * @return string Some words (lorem ipsum).
     */
    public function getWords(int $nbr = 1, bool $UCFirst = true): string
    {
        $words = [];
        $arrayWordsMaxIndex = count($this->words) - 1;
        for ($i=0; $i < $nbr; $i++) {
            do {
                $word = $this->words[rand(0, $arrayWordsMaxIndex)];
            } while ($word === end($words));
            
            if (empty($words) && $UCFirst) {
                $word = ucfirst($word);
            }

            $words[] = $word;
        }

        return implode(' ', $words);;
    }

    /**
     * Give you sentences.
     *
     * @param integer $nbr      Number of sentences needed.
     * @param boolean $endPoint True if you want a point at the end of the sentences. False otherwise.
     * @param boolean $comma    True if you want commas in the sentences. False otherwise.
     * 
     * @return string Some sentences (lorem ipsum).
     * 
     * @throws UnexpectedValueException When the number of sentences asked is lower than 1.
     */
    public function getSentences(int $nbr = 1, bool $endPoint = true, bool $comma = true): ?string
    {
        if ($nbr < 1) {
            throw new UnexpectedValueException ('The $nbr argument can\'t be lower than 1');
        }

        $sentences = [];
        for ($i=0; $i < $nbr; $i++) { 
            $sentence = $this->getSentence($endPoint, $comma);
            $sentences[] = $sentence;
        }
        $sentences = implode(' ', $sentences);

        return $sentences;
    }

    /**
     * Give you one sentence
     *
     * @param boolean $endPoint True if you want a point at the end of the sentence. False otherwise.
     * @param boolean $comma    True if you want commas in the sentence. False otherwise.
     * 
     * @return string
     */
    private function getSentence(bool $endPoint = true, bool $comma = true): string
    {
        $sentence = [];

        $nbrOfPart = rand(1, 4);
        for ($i=0; $i < $nbrOfPart; $i++) { 
            do {
                // Uppercase on the first word.
                if (empty($sentence)) {
                    $curentPart = $this->getWords(rand(1, 6));
                } else {
                    $curentPart = $this->getWords(rand(1, 6), false);
                }

                // Check that the first word of the current part is different to the last word of previous part. (Check in while condition)
                $firstWordCurrent = explode(' ', $curentPart)[0];
                $previousPart = end($sentence);
                if ($previousPart) {
                    $previousPart = explode(' ', $previousPart);
                    $lastWordPrevious = end($previousPart);
                } else {
                    $lastWordPrevious = '';
                }
            } while (strtolower($firstWordCurrent) === strtolower($lastWordPrevious));

            $sentence[] = $curentPart;
        }

        // Add comma
        if ($comma === true) {
            $glue = ', ';
        } else {
            $glue = ' ';
        }
        $sentence = implode($glue, $sentence);

        // Add endpoint
        if ($endPoint) {
            $sentence .= '.';
        }

        return $sentence;
    }
}



