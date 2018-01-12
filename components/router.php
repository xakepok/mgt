<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
class MgtRouter extends JComponentRouterBase
{
    public function build(&$query)
    {
        $segments = array();
	    if ($query['view'] == 'mgt') {
		    unset($query['view']);
	    }
        return $segments;
    }

    public function parse(&$segments)
    {
        $vars = array();
        $menu = JMenu::getInstance('mgt')->getActive();
        switch ($menu->query["view"]) {
	        case 'mgt': {
		        $vars['view'] = 'mgt';
		        break;
	        }
        }
        return $vars;
    }
}