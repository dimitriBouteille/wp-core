<?php

/**
 * @param string $path
 * @return string
 */
function theme_url(string $path): string
{
    return trim(get_template_directory_uri(), '/') . '/' . ltrim($path, '/');
}

/**
 * @param string $path
 * @param string|null $schema
 * @param int|null $blogId
 * @return string
 */
function url(string $path, ?string $schema = null, ?int $blogId = null): string
{
    return get_site_url($blogId, $path, $schema);
}

/**
 * @return string
 */
function wp_ajax_url(): string
{
    return admin_url('admin-ajax.php');
}