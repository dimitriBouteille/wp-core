<?php

namespace Dbout\WpCore\Attachment;

/**
 * Class AttachmentManager
 * @package Dbout\WpCore\Attachment
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2020 Dimitri BOUTEILLE
 */
class AttachmentManager
{

    /**
     * Upload new Attachment
     *
     * @param string $filePath
     * @param string|null $postTitle
     * @param array $attachmentConfig
     * @param bool $generateSubSizes
     * @return int|\WP_Error
     */
    public static function upload(string $filePath, string $postTitle = null, array $attachmentConfig = [], bool $generateSubSizes = false)
    {
        if(!$postTitle) {
            $filename = basename($filePath);
            $postTitle = preg_replace('/\.[^.]+$/', '', $filename);
        }

        $wpFileType = wp_check_filetype($filePath, null);
        $attachment  = [
            'post_mime_type' => $wpFileType['type'],
            'post_content' =>   '',
            'post_status' =>    'inherit',
            'post_title' =>     $postTitle,
        ];

        unset($attachmentConfig['post_title']);
        $attachment = array_merge($attachment, $attachmentConfig);

        $attachmentId = wp_insert_attachment($attachment, $filePath);
        if(!is_wp_error($attachmentId) && $generateSubSizes) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata( $attachmentId, $filePath);
            wp_update_attachment_metadata( $attachmentId,  $attachment_data );
        }

        return $attachmentId;
    }

}