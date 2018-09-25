<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:39
 */

namespace App\Helper;


class GithubInformationExtractor
{
    /**
     * This function returns the filenames found in the commit information given by parameter
     * @param array $commitInformation Commit information provided by the GithubClient service
     * @return array An array with the filenames found in the commit information
     */
    public static function getFileNameInCommitInformation(array $commitInformation): array
    {
        if ( empty( $commitInformation ) || ! isset ($commitInformation[ 'files' ]) )
            return [];
        else
        {
            $filesName = [];
            foreach ( $commitInformation[ 'files' ] as $file )
            {
                if (isset($file['filename']))
                    $filesName[] = $file['filename'];
            }
            return $filesName;
        }
    }
}