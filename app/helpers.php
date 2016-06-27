<?php

/**
 * Checks to see if the current page selected is active.
 *
 * @param array $pages
 */
function is_active($pages = [])
{
    foreach ($pages as $page) {
        if ($page == Request::path()) {
            echo "class='active'";
            break;
        }
    }
}

/**
 * Compares the two values.
 * 
 * @param $value
 * @param $check
 * @return boolean
 */
function is_selected($value, $check)
{
    return $value == $check;
}

/**
 * Return the default value if given value is null.
 *
 * @param string $image
 * @return string
 */
function wrestlerImage($image)
{
    if (!$image) {
        return asset('default_images/wrestler.jpg');
    }
    return $image;
}

/**
 * Return the default image if given value is null.
 *
 * @param string $image
 * @return string
 */
function defaultImage($image)
{
    if (!$image) {
        return asset('default_images/default.jpg');
    }
    return $image;
}