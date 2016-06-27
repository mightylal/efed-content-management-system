<?php
/**
 * Ok, glad you are here
 * first we get a config instance, and set the settings
 * $config = HTMLPurifier_Config::createDefault();
 * $config->set('Core.Encoding', $this->config->get('purifier.encoding'));
 * $config->set('Cache.SerializerPath', $this->config->get('purifier.cachePath'));
 * if ( ! $this->config->get('purifier.finalize')) {
 *     $config->autoFinalize = false;
 * }
 * $config->loadArray($this->getConfig());
 *
 * You must NOT delete the default settings
 * anything in settings should be compacted with params that needed to instance HTMLPurifier_Config.
 *
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 */

return [

    'encoding'  => 'UTF-8',
    'finalize'  => true,
    'cachePath' => storage_path('app/purifier'),
    'settings'  => [
        'default' => [
            'HTML.Allowed'             => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'   => true,
        ],
        'test'    => [
            'Attr.EnableID' => true
        ],
        "youtube" => [
            "HTML.SafeIframe"      => 'true',
            "URI.SafeIframeRegexp" => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%",
        ],
        'fedpage' => [
            'HTML.Allowed'              => 'div[style],b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src],table[border|style],thead,tr,th[style],tbody,td[style],tfoot,hr,h1,h2,h3,h4,h5,h6,iframe[width|height|src|frameborder]',
            'CSS.AllowedProperties'     => 'font,font-size,font-weight,font-style,font-family,text-decoration,color,background-color,text-align,border',
            'AutoFormat.AutoParagraph'  => true,
            'AutoFormat.RemoveEmpty'    => true,
            "HTML.SafeIframe"           => true,
            "URI.SafeIframeRegexp"      => "%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%",
        ],
        'roleplay' => [
            'HTML.Allowed'              => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties'     => 'font,font-size,font-weight,font-style,font-family,text-decoration,color,background-color,text-align',
            'AutoFormat.AutoParagraph'  => true,
            'AutoFormat.RemoveEmpty'    => true
        ],
    ],

];
