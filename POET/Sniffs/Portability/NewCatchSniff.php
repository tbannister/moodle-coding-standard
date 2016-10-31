<?php
/**
 * POET_Sniffs_Portability_NewCatchSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewCatchSniff.
 *
 * This test checks to see if catching multiple exception types in one statement are used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewCatchSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_CATCH);
    }//end register()

    /**
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $token  = $tokens[$stackptr];
        $content = $tokens[$stackptr]['content'];

        $hasbitwiseor = $phpcsfile->findNext(T_BITWISE_OR, $token['parenthesis_opener'], $token['parenthesis_closer']);
        if ($hasbitwiseor === false) {
            return;
        }
        $warning = 'Catching multiple exceptions within one statement is only supported in PHP 7.0 or greater.';
        $warning = $warning .'The method should not be used.';
        $phpcsfile->addWarning($warning, $hasbitwiseor, 'Found');
    }
}
