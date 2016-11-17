<?php
// Namespace
namespace Command;

/**
 * Communicates with AIML.
 * arguments[0] == String to process.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Sam W <sam@seven-labs.com>
 */
class Ai extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = 'Use AIML to process a string.';
    
    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = 'ai <Text to send>';

    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;
    
    /**
     * Verify the user before executing this command.
     *
     * @var bool
     */
    protected $verify = true;

    /**
     * Send raw data to server.
     *
     * IRC-Syntax: RAW [DATA]
     */
    public function command() {
        if (!strlen($this->arguments[0]))
		{
			$this->say($this->usage);
			return;
		}
		// http://sdw.seven-labs.com/Program-O/chatbot/conversation_start.php?bot_id=1&convo_id=&say=what%20is%20my%20name&format=xml		
		// trim(implode( ' ', array_slice( $this->arguments, 1 ) ))
		$strSource = $this->source;
		$strHost = $this->getUserHost();
		
		$UserOutput = trim(implode( ' ', array_slice( $this->arguments, 0 ) ));
		$this->bot->log("<$strSource> <$strHost> asks: $UserOutput");
		
		$this->bot->log("Probing AIML API...");
		$BotResponse = $this->getResponse($UserOutput, $strHost);
		$this->bot->log("AIML Response: $BotResponse");
		
		$this->connection->sendData(
            'PRIVMSG ' . $this->source .
            ' :'. $BotResponse
        );
		
    }
    
    
    protected function getResponse($strRequest, $strHost) {
        
        $response = $this->fetch("http://sdw.seven-labs.com/Program-O/chatbot/conversation_start.php?bot_id=1&convo_id=" . md5($strHost) . "&say=" . urlencode($strRequest) . "&format=json");

        $jsonResponse = json_decode($response);
	
        if ($jsonResponse) {
           //shell_exec("espeak -ven+f3 -k5 -s150 \"$jsonResponse->botsay\" -a180 ");
           return $jsonResponse->botsay;
	}

        return null;
    }
}
?>
