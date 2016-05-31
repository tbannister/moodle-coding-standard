<?php
/**
 * POET_Sniffs_Vendor_DisallowJquerySniff.
 *
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */

/**
 * A Sniff to warn about manually including the jQuery libraries
 * as opposed to using the ones bundled with Moodle core.
 *
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 */
class POET_Sniffs_Vendor_DisallowJquerySniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CONSTANT_ENCAPSED_STRING,
            T_DOUBLE_QUOTED_STRING,
        );

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

        $content = trim($tokens[$stackPtr]['content'], '\'"');

        if (preg_match('/jquery(\.|-).+js$/i', $content) === 1) {
            $this->_addError($phpcsFile, $stackPtr);
        }
    }

    /**
     * Add an error for the found path
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned
     * @param int                  $stackPtr  The pointer to the element in the stack
     *
     * @return void
     */
    private function _addError($phpcsFile, $stackPtr)
    {
        $type  = 'jQueryComponents';
        $error = 'Including jQuery et al. directly is strongly discouraged.';
        $data  = array();
        $phpcsFile->addError($error, $stackPtr, $type, $data);

    }
}
