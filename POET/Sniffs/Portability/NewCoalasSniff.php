<?php
/**
 * POET_Sniffs_Portability_NewCoalasSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewCoalasSniff.
 *
 * This test checks to see if a new operator is used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewCoalasSniff implements PHP_CodeSniffer_Sniff {

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_OPEN_TAG);
        
    }
    public function process(PHP_CodeSniffer_File $phpcsfile,$stackptr) {
        $tokens = $phpcsfile->getTokens();
        print_r($tokens);
        exit();
    }
}