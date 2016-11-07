<?php
/**
 * POET_Sniffs_Portability_NewGroupusetSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewGroupuseSniff.
 *
 * This test checks to see if constant arrays using define are used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewGroupuseSniff implements PHP_CodeSniffer_Sniff 
{
    /* Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_OPEN_USE_GROUP);
    }//end register()

    /**
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $warning = 'Group use declarations are used in PHP8 and above. They should not be used.';
        $phpcsfile->addWarning($warning, $stackptr);
    }
}
