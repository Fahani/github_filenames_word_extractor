<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:34
 */

namespace App\Helper;


class FilenameWordSplitter
{
    /**
     * Split the filename of file into words. The words are split by the capital letter in the filename.
     * @param string $filename. The filename to analyze.
     * @param string $fileExtension. Optional, filter files to consider by its extension
     * @return string[] The words in the filename
     */
    public static function filenameToWords(string $filename, string $fileExtension = ""): array
    {
        $parts=pathinfo($filename);

        if(empty($fileExtension) && isset($parts['extension']))
        {
            $fileExtension = $parts['extension'];
        }

        if (isset($parts['extension']) && $parts['extension'] == $fileExtension) {
            $words = preg_split('/(?=[A-Z])/',$parts['filename']);
            return array_filter($words);
        }

        return [];
    }
}