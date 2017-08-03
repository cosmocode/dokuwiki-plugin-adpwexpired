<?php
/**
 * DokuWiki Plugin adpwexpired (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_adpwexpired extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {
       $controller->register_hook('HTML_LOGINFORM_OUTPUT', 'BEFORE', $this, 'handle_loginform');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_loginform(Doku_Event &$event, $param) {
        /** @var DokuWiki_Auth_Plugin $auth*/
        global $auth;
        if(empty($_REQUEST['u'])) return; // not a login attempt
        $user = $_REQUEST['u'];

        $info = $auth->getUserData($user);
        if(isset($info['expiresin']) && $info['expiresin'] <= 0){
            $event->data->addElement('<div class="adpwexpired">'.$this->locale_xhtml('info').'</div>');
        }
    }

}

// vim:ts=4:sw=4:et:
