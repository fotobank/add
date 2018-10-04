<?php
require_once dirname(__DIR__) . "/parser/exceptions/parser-exception.php";
require_once dirname(__DIR__) . "/parser/tokenizer.php";

/**
 * class Parser
 * Parses a string.
 */
abstract class Parser extends Tokenizer {
    /**
     * This flag indicates that we want to perform a "non-greedy" analysis.
     */
    const UNGREEDY = 0x4;
    
    /**
     * Flags.
     * @var int
     */
    private $flags;
    
    /**
     * @param string $str
     * @param int $flags = 0
     */
    public function __construct($str, $flags = 0) {
        parent::__construct($str);
        $this->flags = $flags;
    }
    
    /**
     * Parses a string.
     * @return mixed
     */
    abstract protected function _parse();
    
    /**
     * Tries to parse a string and throws an exception if unsuccessful.
     * This is the habitual use of the parser method:
     * 
     * <code>
     * $p = new MyCustomParser($string);
     * try {
     *      $info = $p->parse();
     *      // .. more lines ..
     * } catch(ParserException $e) {
     *      echo $e->getPrintableMessage();
     * }
     * </code>
     * 
     * @throws Exception
     * @return mixed
     */
    public function parse() {
        $ungreedy = Parser::UNGREEDY & $this->flags;
        $ret = $this->_parse();
        
        if (!$ret || !$ungreedy && !$this->end()) {
            throw new ParserException($this, "Unrecognized expression");
        }
        
        return $ret;
    }
    
    /**
     * Matches the string against a function and moves the offset forward if the function returns TRUE.
     * @param string $method_name Method name
     * @param array $args Additional arguments
     * @throws Exception
     * @return mixed
     */
    protected function is($method_name, $args = NULL /* ... additional arguments */) {
        if (!method_exists($this, $method_name)) {
            throw new Exception("The method `$method_name` does not exist");
        }
        
        if (!is_callable(array($this, $method_name))) {
            throw new Exception("The method `$method_name` is inaccessible");
        }
        
        $offset = $this->offset;  // saves offset
        $ret = call_user_func_array(array($this, $method_name), array_slice(func_get_args(), 1));
        if (!$ret) {
            $this->offset = $offset;  // restores offset
        }
        
        return $ret;
    }
}
