<?php
/**
 * POET_Tests_Performance_LoopedFunctionUnitTest.
 *
 * @copyright Copyright (c) 2016 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Unit tests for POET_Sniffs_Performance_LoopedFunctionSniff.
 * @group poet
 */
class POET_Tests_Performance_LoopedFunctionUnitTest extends AbstractSniffUnitTest {
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    protected function getErrorList()
    {
        return [];
    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    protected function getWarningList()
    {
        return [
            8 => 1,
            14 => 1,
            20 => 1,
            26 => 1,
        ];
    }
}