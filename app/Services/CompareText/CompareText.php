<?php
/**
 * Created by PhpStorm.
 * User: silivanov
 * Date: 06.03.17
 * Time: 14:43
 */
declare(strict_types = 1);

namespace App\Services\CompareText;

use App\Services\CompareText\Core\CompareTextInterface;

/**
 * Class CompareText
 * @package App\Services\CompareText
 */
class CompareText implements CompareTextInterface
{
    /**
     *
     * @var string
     */
    protected $originalText;

    /**
     * @var string
     */
    protected $newText;

    /**
     * @var float
     */
    private $accuracy = 50;

    /**
     * CompareText constructor.
     * @param string $originalText
     * @param string $newText
     */
    public function __construct(string $originalText, string $newText)
    {
        $this->originalText = $originalText;
        $this->newText = $newText;
    }

    /**
     * @param string $text
     * @return array
     */
    public function textToArray(string $text): array
    {
        $arr = $this->deleteSpace(explode('.', $text));
        unset($arr[count($arr) - 1]);
        return $arr;
    }

    /**
     * @return array
     */
    public function compare(): array
    {
        $originalArray = $this->textToArray($this->originalText);
        $newArray = $this->textToArray($this->newText);
        //dd($newArray);
        //unset($newArray[count($newArray) - 1]);
        $result = [];
        $delete = [];
        foreach ($originalArray as $originalKey => $original) {
            $max = 0; /// максимальное совпадение
            $changeValue = '';
            $changeKey = '';

            foreach ($newArray as $newKey => $new) {
                similar_text($original, $new, $percent);
                if ($percent == 100) {
                    $max = $percent;
                    unset($newArray[$newKey]);
                    break;
                } else if ($max < $percent) {
                    $max = $percent;
                    $changeValue = $new;
                    $changeKey = $newKey;
                }
            }
            if ($max == 100) {
                $result[$originalKey] = [
                    'type' => 'old',
                    'value' => $original
                ];
            } else if ($max > $this->accuracy) {
                $result[$originalKey] = [
                    'type' => 'change',
                    'origin' => $original,
                    'value' => $changeValue
                ];
                unset($newArray[$changeKey]);
            } else {
                $result[$originalKey] = [
                    'type' => 'delete',
                    'value' => $original
                ];
            }
        }
        return [
            'res' => $result,  //// все кроме новых
            'add' => $newArray
        ];
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        $result = [];
        $arr = $this->compare();
        $oldArray = $arr['res'];
        $newArray = $arr['add'];
      //  $count = count($oldArray) + count($addArray);
        //dd($addArray);
        //dd($count);
     /*   foreach ($oldArray as $k => $v) {
            echo "$k => " . $v['type'] . " => " . $v['value'] . " <br>";
        }
        echo "<hr>";
       // dd($addArray);
        foreach ($addArray as $k => $v) {
            echo "$k => " . $v['type'] . " => " . $v['value'] . " <br>";
        }
        echo "<hr>";
        exit();
        print_r($addArray);*/
        $j = 0;
        $r = 0;

        $last = [];
        $count = count($oldArray) + count($newArray);
        for($i = 0; $i < count($oldArray); $i++) {
                array_push($last, $oldArray[$i]);
            if(isset($newArray[$i]))
                array_push($last, ['type' => "new", 'value' => $newArray[$i]]);
        }
      //  dd($last);
      /*  for ($i = 0; $i < $count; $i++) {
            if (isset($addArray[$i])) {
                $result[$j + 1] = $addArray[$i];
                unset($addArray[$i]);
                $i--;
            } else {
                if (isset($oldArray[$i])) {
                    if ($oldArray[$i]['type'] == 'delete') {
                        //$r++;
                    }
                    $result[$j] = $oldArray[$i];
                    unset($oldArray[$i]);
                }
            }
            $j++;
        }*/

        return $last;
    }

    /**
     * @param array $arr
     * @return array
     */
    public function deleteSpace(array $arr): array
    {
        $arrayNoSpace = [];
        foreach ($arr as $key => $v) {
            $arrayNoSpace[$key] = trim($v);
        }

        return $arrayNoSpace;
    }

    /**
     * @param array $addedText
     * @return array
     */
    public function getNewSentence($addedText, $oldArray): array
    {
        $arr = [];
        $count = count($oldArray) + count($addedText);
        //dd($this->newSentence);
        $j = 0;
      /*  for ($i = 0; $i < $count; $i++) {
            if (isset($oldArray[$i])) {
                if ($oldArray[$i]['type'] == 'delete') {
                    $j++;
                }
            }
            if (isset($addedText[$i])) {
                //$tmp [] = ;
                $arr[$i] = ['type' => 'new', 'value' => $addedText[$i]];
            }
            $j++;
        }*/
        foreach ($addedText as $k => $item) {
            if ($item != '') {
                $arr[$k]['type'] = 'new';
                $arr[$k]['value'] = $item;
            }
        }

        return $arr;
    }
}