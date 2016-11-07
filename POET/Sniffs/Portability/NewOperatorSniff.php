<?php
/**
 * POET_Sniffs_Portability_NewOperatorSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewOperatorSniff.
 *
 * This test checks to see if a new operator is used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewOperatorSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_SPACESHIP,T_COALESCE);
    }//end register()

    /**
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $optype = $tokens[$stackptr]['type'];
        if ($optype === 'T_SPACESHIP') {
            $warning = 'Spaceship operators should only be used in PHP 7.0 or greater. ';
            $phpcsfile->addWarning($warning, $stackptr);
        }
        if ($optype === 'T_COALESCE' ) {
            $warning = 'Coalesce operators should only be used in PHP 7.0 or greater. ';
            $phpcsfile->addWarning($warning, $stackptr);
        }
    }
}