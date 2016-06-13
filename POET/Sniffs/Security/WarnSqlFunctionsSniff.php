<?php
/**
 * POET_Sniffs_Security_DisallowParamConstantsSniff.
 *
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */

/**
 * A Sniff to warn about the use of the _sql database functions
 *
 * @category  PHP
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */
class POET_Sniffs_Security_WarnSqlFunctionsSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_VARIABLE];
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $content = $tokens[$stackPtr]['content'];

        // Only check for functions using the $DB variable.
        if ($content !== '$DB') {
            return;
        }

        // Find the name of the function.
        $functionPtr = $phpcsFile->findNext(T_STRING, $stackPtr, null, false, null, true);

        if ($functionPtr === false) {
            return; // Failed to find the function call.
        }

        // Add a warning for functions that take raw sql.
        $function = $tokens[$functionPtr]['content'];

        $sqlPos = strrpos($function, '_sql');
        if ($sqlPos !== false && ($sqlPos + 4) === strlen($function)) {
            $this->_addWarning($function, $phpcsFile, $stackPtr);
            return;
        }

        $menuPos = strrpos($function, '_sql_menu');
        if ($menuPos !== false && ($menuPos + 9) === strlen($function)) {
            $this->_addWarning($function, $phpcsFile, $stackPtr);
            return;
        }

        if ($function === 'execute') {
            $this->_addWarning($function, $phpcsFile, $stackPtr);
            return;
        }
    }

    /**
     * Add a warning for the found function
     *
     * @param string               $function  The name of the function found
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned
     * @param int                  $stackPtr  The pointer to the element in the stack
     *
     * @return void
     */
    private function _addWarning($function, $phpcsFile, $stackPtr)
    {
        $type  = 'SqlFunctionUsed';
        $error = 'Use of the %s database function found. ';
        $error .= 'Check the SQL for parameter injection / complexity.';
        $data = [$function];
        $phpcsFile->addWarning($error, $stackPtr, $type, $data);
    }
}
