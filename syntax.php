<?php
/**
 * Plugin Now: Inserts a timestamp.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christoph Lang <calbity@gmx.de>
 */

// based on http://wiki.splitbrain.org/plugin:tutorial

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

    function getInfo() {
        return array(
        'author'  => 'Christoph Lang',
        'email'   => 'calbity@gmx.de',
        'date'    => '2009-01-20',
        'name'    => 'Webthumbnails Plugin',
        'desc'    => 'Zeigt Thumbnails von Webseiten an.',
        'url'     => 'http://www.google.de'
        );
    }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\<webthumb\:.*?\>', $mode, 'plugin_webthumbs');
    }

    function getType() { return 'substition'; }

    function getSort() { return 267; }

    function handle($match, $state, $pos, &$handler) {

          $aResponse = array();
         $temp = substr($match,10,-1);
         $aResponse = explode("|",$temp);
          if(!isset($aResponse[1]))
           $aResponse[1] = $aResponse[0];
        return $aResponse;

    }
    function _preview($data) {

                $sResponse = "";

                $sResponse = '<a href="'.$data[1].'"><img src="'.$this->sWebService.$data[0].'" style="border: 1px solid black;" /></a>';
                return $sResponse;

    }

    function render($mode, &$renderer, $data) {

        if ($mode == 'xhtml') {
                $renderer->doc .= $this->_preview($data);

            return true;
        }
        return false;
    }
}
