<?php
/**
 * POET_Sniffs_Portability_NewVisibilitySniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewVisibilitySniff.
 *
 * This test checks for visibility for class indicators 
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewVisibilitySniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_CONST);
    }//end register()
    public function tokenHasScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $validScopes = null)
    {
        $tokens = $phpcsFile->getTokens();
        // Check for the existence of the token.
        if (isset($tokens[$stackPtr]) === false) {
            return false;
        }
        // No conditions = no scope.
        if (empty($tokens[$stackPtr]['conditions'])) {
            return false;
        }
        // Ok, there are conditions, do we have to check for specific ones ?
        if (isset($validScopes) === false) {
            return true;
        }
        if (is_int($validScopes)) {
            // Received an integer, so cast to array.
            $validScopes = (array) $validScopes;
        }
        if (empty($validScopes) || is_array($validScopes) === false) {
            // No valid scope types received, so will not comply.
            return false;
        }
        // Check for required scope types.
        foreach ($tokens[$stackPtr]['conditions'] as $pointer => $tokenCode) {
            if (in_array($tokenCode, $validScopes, true)) {
                return true;
            }
        }
        return false;
    }
    /**
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $prevToken = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr - 1), null, true, null, true);
        if ($prevToken === false) {
            return;
        }
                // Is the previous token a visibility indicator ?
        if (in_array($tokens[$prevToken]['code'], PHP_CodeSniffer_Tokens::$scopeModifiers, true) === false) {
            return;
        }
        if ($this->tokenHasScope($phpcsFile, $stackPtr, array(T_CLASS, T_INTERFACE)) === true ) {
            $warning = 'Visibility indicators for class constants are only supported in PHP 7.1 or greater. It should not  be used';
            $warning = $warning .'Found "%s const"';
            $data  = array($tokens[$prevToken]['content']);
            $phpcsFile->addError($warning, $stackPtr, 'Found', $data);
        }
        
    }
}
