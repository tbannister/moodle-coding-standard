<?php
/**
 * POET_Sniffs_Security_DisallowParamConstantsSniff.
 *
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */

/**
 * A Sniff to warn about using deprecated PARAM_* constants in Moodle.
 *
 * @category  PHP
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */
class POET_Sniffs_Security_DisallowParamConstantsSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of parameter constants and their alternatives.
     *
     * @var array
     */
    private $_constants = [
        'PARAM_RAW'       => '',
        'PARAM_CLEAN'     => '',
        'PARAM_INTEGER'   => 'PARAM_INT',
        'PARAM_NUMBER'    => 'PARAM_FLOAT',
        'PARAM_ACTION'    => 'PARAM_ALPHANUMEXT',
        'PARAM_FORMAT'    => 'PARAM_ALPHANUMEXT',
        'PARAM_MULTILANG' => 'PARAM_TEXT',
        'PARAM_CLEANFILE' => 'PARAM_FILE',
    ];

    /**
     * Return the token types that this Sniff is interested in
     *
     * @return array
     */
    public function register()
    {
        return [T_STRING];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $name = trim($tokens[$stackPtr]['content']);

        if (isset($this->_constants[$name]) === true) {
            $this->addError($phpcsFile, $stackPtr, $name);
        }
    }

    /**
     * Generates the error or warning for this sniff.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the forbidden function
     *                                        in the token array.
     * @param string               $param     The name of the forbidden param.
     *
     * @return void
     */
    protected function addError($phpcsFile, $stackPtr, $param)
    {
        $data = [$param];
        $error = 'The use of the constant %s is strongly discouraged.';

        if (empty($this->_constants[$param]) === false) {
            $error .= " Use '".$this->_constants[$param]."' instead.";
            $phpcsFile->addError($error, $stackPtr, 'Discouraged', $data);
        } else {
            $phpcsFile->addWarning($error, $stackPtr, 'Discouraged', $data);
        }
    }
}