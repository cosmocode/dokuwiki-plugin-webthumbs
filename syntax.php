<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christoph Lang <calbity@gmx.de>
 * @author     Andreas Gohr <gohr@cosmocode.de>
 */


// must be run within DokuWiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once(DOKU_PLUGIN . 'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_webthumbs extends DokuWiki_Syntax_Plugin {

    //http://open.thumbshots.org/image.pxf?url=http://www.sdzecom.de
    //http://www.thumbshots.de/cgi-bin/show.cgi?url=http://www.sdzecom.de
    private $sWebService = "http://open.thumbshots.org/image.pxf?url=";

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\<webthumb\:.*?\>', $mode, 'plugin_webthumbs');
    }

    function getType() { return 'substition'; }

    function getSort() { return 267; }

    function handle($match, $state, $pos, &$handler) {
        $match = substr($match,10,-1);

        list($url,$link) = explode('|',$match,2);
        $url  = trim($url);
        $link = trim($link);
        if(!$link) $link = $url;

        return array($url,$link);
    }

    function render($mode, &$R, $data) {
        $image = array(
            'src'   => $this->sWebService.rawurlencode($data[0]).'&.png',
            'cache' => 'nocache',
        );
        $R->externallink($data[1],$image);

        return true;
    }
}
