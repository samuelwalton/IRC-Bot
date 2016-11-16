<?php
// Namespace
namespace Command;

/**
 * Rejoins the specified channel.
 * arguments[0] == Channel to join.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Rejoin extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = 'Make the bot rejoin a channel.';
    
    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = 'rejoin [#channel]';

    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $numberOfArguments = 1;
    
    /**
     * Verify the user before executing this command.
     *
     * @var bool
     */
    protected $verify = true;

    /**
     * ReJoins the specified channel.
     *
     * IRC-Syntax: REJOIN [#channel]
     */
    public function command() {
    	  $this->connection->sendData('PART '.$this->arguments[0] . ' brb');
        $this->connection->sendData('JOIN '.$this->arguments[0]);
    }
}
?>