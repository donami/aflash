<?php

namespace donami\AFlash;

/**
 * Class for handling messages and notifications
 *
 * @package AFlash
 */
class AFlash
{
    private $htmlBefore = '<div class="alert-box %s">';
    private $htmlAfter  = '</div>';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        if (!array_key_exists('messages', $_SESSION)) {
            $_SESSION['messages'] = array();
        }
    }

    /**
     * Add a message
     * 
     * @param string $type
     * @param strng $message
     * @param string $location
     *  
     * @return void
     */
    public function add($type, $message, $location = null)
    {
        $_SESSION['messages'][$type][] = $message;

        if (!is_null($location)) {
            header("location: " . $location);
            die();
        }
    }

    /**
     * Clear the added messages
     * 
     * @return void
     */
    private function clear()
    {
        $_SESSION['messages'] = array();
    }

    /**
     * Display the messages
     * 
     * @return string
     */
    public function display()
    {
        $messages = $_SESSION['messages'];

        $html = '';

        foreach ($messages as $type => $value) {
            switch (strtoupper($type)) {
                case 'E':
                    $class = 'error';
                    break;
                
                case 'S':
                    $class = 'success';
                    break;

                default:
                    $class = 'notification';
                    break;
            }

            $html .= sprintf($this->htmlBefore, $class);

            foreach ($value as $k => $msg) {
                $html .= sprintf('<div>%s</div>', $msg);
            }

            $html .= $this->htmlAfter;
        }

        $this->clear();

        return $html;
    }


}
