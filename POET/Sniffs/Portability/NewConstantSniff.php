<?php
/**
 * POET_Sniffs_Portability_NewConstantSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_NewConstantSniff.
 *
 * This test checks to see if constant arrays using define are used
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Portability_NewConstantSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_STRING);
    }//end register()

    /**
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $ignore = array(
            T_DOUBLE_COLON,
            T_OBJECT_OPERATOR,
            T_FUNCTION,
            T_CONST,
        );
        $prevtoken = $phpcsfile->findPrevious(T_WHITESPACE, ($stackptr - 1), null, true);
        if (in_array($tokens[$prevtoken]['code'], $ignore) === true) {
            /* Not a call to a PHP function. */
            return;
        }
        $function = strtolower($tokens[$stackptr]['content']);
        if ($function !== 'define') {
            return;
        }
        $secondparam = $this->getFunctionCallParameter($phpcsfile, $stackptr, 2);
        if (isset($secondparam['start'], $secondparam['end']) === false) {
            return;
        }
        $array = $phpcsfile->findNext(array(T_ARRAY, T_OPEN_SHORT_ARRAY), $secondparam['start'], ($secondparam['end'] + 1));
        if ($array !== false) {
            $warning = 'Constant arrays using define are suppported in PHP7 and above. They should not be used.';
            $phpcsfile->addWarning($warning, $array);
        }
    }
    public function getfunctioncallparameters(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        if ($this->doesfunctioncallhaveparameters($phpcsfile, $stackptr) === false) {
            return array();
        }
        // Ok, we know we have a T_STRING with parameters and valid open & close parenthesis.
        $tokens = $phpcsfile->getTokens();
        $openparenthesis  = $phpcsfile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $stackptr + 1, null, true, null, true);
        $closeparenthesis = $tokens[$openparenthesis]['parenthesis_closer'];
        $nestedparenthesiscount = 0;
        // Which nesting level is the one we are interested in ?
        $nestedparenthesiscount = 1;
        if (isset($tokens[$openparenthesis]['nested_parenthesis'])) {
            $nestedparenthesiscount = count($tokens[$openparenthesis]['nested_parenthesis']) + 1;
        }
        $parameters = array();
        $nextcomma  = $openparenthesis;
        $paramstart = $openparenthesis + 1;
        $cnt        = 1;
        while ($nextcomma = $phpcsfile->findNext(array(T_COMMA, T_CLOSE_PARENTHESIS, T_OPEN_SHORT_ARRAY),
                $nextcomma + 1, $closeparenthesis + 1)) {
            // Ignore anything within short array definition brackets.
            if (
                $tokens[$nextcomma]['type'] === 'T_OPEN_SHORT_ARRAY'
                &&
                ( isset($tokens[$nextcomma]['bracket_opener']) && $tokens[$nextcomma]['bracket_opener'] === $nextcomma )
                &&
                isset($tokens[$nextcomma]['bracket_closer'])
            ) {
                // Skip forward to the end of the short array definition.
                $nextcomma = $tokens[$nextcomma]['bracket_closer'];
                continue;
            }
            // Ignore comma's at a lower nesting level.
            if (
                $tokens[$nextcomma]['type'] === 'T_COMMA'
                &&
                isset($tokens[$nextcomma]['nested_parenthesis'])
                &&
                count($tokens[$nextcomma]['nested_parenthesis']) !== $nestedparenthesiscount
            ) {
                continue;
            }
            // Ignore closing parenthesis if not 'ours'.
            if ($tokens[$nextcomma]['type'] === 'T_CLOSE_PARENTHESIS' && $nextcomma !== $closeparenthesis) {
                continue;
            }
            // Ok, we've reached the end of the parameter.
            $parameters[$cnt]['start'] = $paramstart;
            $parameters[$cnt]['end']   = $nextcomma - 1;
            $parameters[$cnt]['raw']   = trim($phpcsfile->getTokensAsString($paramstart, ($nextcomma - $paramstart)));
            // Check if there are more tokens before the closing parenthesis.
            $hasnextparam = $phpcsfile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $nextcomma + 1,
                    $closeparenthesis, true, null, true);
            if ($hasnextparam === false) {
                break;
            }
            // Prepare for the next parameter.
            $paramstart = $nextcomma + 1;
            $cnt++;
        }
        return $parameters;
    }
    /**
     * Get information on a specific parameter passed to a function call.
     *
     * Expects to be passed the T_STRING stack pointer for the function call.
     * If passed a T_STRING which is *not* a function call, the behaviour is unreliable.
     *
     * Will return a array with the start token pointer, end token pointer and the raw value
     * of the parameter at a specific offset.
     * If the specified parameter is not found, will return false.
     *
     * @param PHP_CodeSniffer_File $phpcsfile   The file being scanned.
     * @param int                  $stackftr    The position of the function call token.
     * @param int                  $paramoffset The 1-based index position of the parameter to retrieve.
     *
     * @return array|false
     */
    public function getfunctioncallparameter(PHP_CodeSniffer_File $phpcsfile, $stackptr, $paramoffset) {
        $parameters = $this->getfunctioncallparameters($phpcsfile, $stackptr);
        if (isset($parameters[$paramoffset]) === false) {
            return false;
        } else {
            return $parameters[$paramoffset];
        }
    }
    public function doesfunctioncallhaveparameters(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        // Check for the existence of the token.
        if (isset($tokens[$stackptr]) === false) {
            return false;
        }
        if ($tokens[$stackptr]['code'] !== T_STRING) {
            return false;
        }
        // Next non-empty token should be the open parenthesis.
        $openparenthesis = $phpcsfile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $stackptr + 1, null, true, null, true);
        if ($openparenthesis === false || $tokens[$openparenthesis]['code'] !== T_OPEN_PARENTHESIS) {
            return false;
        }
        if (isset($tokens[$openparenthesis]['parenthesis_closer']) === false) {
            return false;
        }
        $closeparenthesis = $tokens[$openparenthesis]['parenthesis_closer'];
        $nextnonempty     = $phpcsfile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $openparenthesis + 1,
                $closeparenthesis + 1, true);
        if ($nextnonempty === $closeparenthesis) {
            // No parameters.
            return false;
        }
        return true;
    }

}
