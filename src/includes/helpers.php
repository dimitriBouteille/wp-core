<?php

/**
 * @param string $path
 * @return string
 */
function _theme_url(string $path): string
{
    return trim(get_template_directory_uri(), '/') . '/' . ltrim($path, '/');
}

/**
 * @param string $path
 * @param string|null $schema
 * @param int|null $blogId
 * @return string
 */
function _url(string $path, ?string $schema = null, ?int $blogId = null): string
{
    return get_home_url($blogId, $path, $schema);
}

/**
 * @param string $path
 * @param string|null $schema
 * @param int|null $blogId
 * @return string
 */
function _site_url(string $path, ?string $schema = null, ?int $blogId = null): string
{
    return get_site_url($blogId, $path, $schema);
}

/**
 * @return string
 */
function _wp_ajax_url(): string
{
    return admin_url('admin-ajax.php');
}