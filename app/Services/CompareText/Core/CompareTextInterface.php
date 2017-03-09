<?php
/**
 * Created by PhpStorm.
 * User: silivanov
 * Date: 06.03.17
 * Time: 14:44
 */
declare(strict_types=1);

namespace App\Services\CompareText\Core;

/**
 * Interface CompareTextInterface
 * @package App\Compare
 */
interface CompareTextInterface
{

    /**
     * CompareTextInterface constructor.
     * @param string $originalText
     * @param string $newText
     */
    public function __construct(string $originalText, string $newText);

    /**
     * @param string $text
     * @return array
     */
    public function textToArray(string $text):array;

    /**
     * @return array
     */
    public function compare():array;

    /**
     * @return array
     */
    public function getResult():array;

    /**
     * @param array $arr
     * @return array
     */
    public function deleteSpace(array $arr):array;

}