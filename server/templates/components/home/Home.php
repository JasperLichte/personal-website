<?php

namespace templates\components\home;

require_once __DIR__ . './../../HtmlHelper.php';
require_once __DIR__ . './../Component.php';
require_once 'HomeSectionsContentHelper.php';

use base\config\Config;
use templates\components\Component;
use templates\components\HomeSectionsContentHelper;
use templates\HtmlHelper;

class Home extends Component
{

    const ID = 'home';
    const NAME = 'Home';

    /**
     * @return string
     */
    public static function MAIN_JS_FILE() {
        return Config::MAIN_JS_FILE();
    }

    /**
     * @return string
     */
    private static function buildHeader()
    {
        return HtmlHelper::element(
            'header',
            [],
            HtmlHelper::div(
                ['id' => 'header-wrapper'],
                self::buildSideMenuToggle() . self::buildSideMenu()
            )
        );
    }

    /**
     * @return string
     */
    private static function buildSideMenuToggle()
    {
        return HtmlHelper::button(
            ['id' => 'side-menu-toggle',],
            HtmlHelper::span() . HtmlHelper::span() . HtmlHelper::span()
        );
    }

    /**
     * @return string
     */
    private static function buildSideMenu()
    {
        return HtmlHelper::element(
            'nav',
            [
                'id' => 'side-menu',
            ],
            HtmlHelper::button(
                ['id' => 'side-menu-close'],
                'close'
            )
        );
    }

    /**
     * @return string
     */
    private static function buildMain()
    {
        $sections = HomeSectionsContentHelper::getSections();
        $sectionsInFirstColumn = ceil(count($sections) / 2);
        $column1Html = $column2Html = [];
        $i = 0;
        foreach ($sections as $key => $section) {
            $header = (isset($section['header']) && !empty($section['header'])
                ? HtmlHelper::element('h2', ['class' => 'section-header'], $section['header'])
                : '');
            $content = (isset($section['content']) && !empty($section['content'])
                ? HtmlHelper::element('div', ['class' => 'content-wrapper'], $section['content'])
                : '');

            if (!($content || $header)) {
                continue;
            }

            $html = HtmlHelper::element(
                'section',
                [
                    'class'             => 'content-section',
                    'id'                => 'content-section-' . $key,
                    'data-section-name' => $key,
                ],
                HtmlHelper::element(
                    'div',
                    ['class' => 'border-transition-helper'],
                    ($header . $content)
                )
            );

            if (++$i <= $sectionsInFirstColumn) {
                $column1Html[] = $html;
            } else {
                $column2Html[] = $html;
            }
        }
        $column1Html = HtmlHelper::element(
            'div',
            ['class' => 'column', 'id' => 'column-1',],
            implode('', $column1Html)
        );
        $column2Html = HtmlHelper::element(
            'div',
            ['class' => 'column', 'id' => 'column-2',],
            implode('', $column2Html)
        );

        return HtmlHelper::element(
            'main',
            [],
            HtmlHelper::element(
                'div',
                ['id' => 'main-wrapper'],
                ($column1Html . $column2Html)
            )
        );
    }

    /**
     * @return string
     */
    private static function buildFooter()
    {
        $links = [
            HtmlHelper::textLink(
                'mailto:' . Config::get('CREATOR_EMAIL'),
                ['id' => 'creator-email', 'class' => 'btn',],
                'Send me an eMail!'
            ),
            HtmlHelper::textLink(
                Config::get('REPO_URL'),
                ['id' => 'repo_url', 'class' => 'btn',],
                'View the code'
            ),
        ];
        $footerContent = [
            HtmlHelper::element('span', ['id' => 'creator-name'], Config::get('CREATOR_NAME')),
            HtmlHelper::element('div', ['id' => 'links'], implode('', $links)),
        ];
        return HtmlHelper::element(
            'footer',
            [],
            HtmlHelper::element(
                'div',
                ['id' => 'footer-wrapper'],
                implode('', $footerContent)
            )
        );
    }

    /**
     * @return string
     */
    public static function build()
    {
        return
            (HtmlHelper::element(
                    'div',
                    ['id' => 'page'],
                    (self::buildHeader()
                        . self::buildMain()
                        . self::buildFooter())
                ) .
                HtmlHelper::element(
                    'canvas',
                    ['id' => 'bg-canvas']
                ));
    }

}
