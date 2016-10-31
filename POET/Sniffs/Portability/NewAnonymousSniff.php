<?php
/**
 * POET_Sniffs_Portability_NewAnonymousSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewAnonymousSniff.
 *
 * This test checks to see if constant arrays using define are used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewAnonymousSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_NEW);
    }//end register()

    /**
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $whitespace = $phpcsfile->findNext(T_WHITESPACE, $stackptr + 1, $stackptr + 2);
        $class      = $phpcsfile->findNext(T_ANON_CLASS, $stackptr + 2, $stackptr + 3);
        if ($whitespace === false || $class === false) {
            return;
        }
        $phpcsfile->addWarning('Anonymous classes are only supported in PHP 7 and above. They should not be used.', $stackptr);
    }
}
