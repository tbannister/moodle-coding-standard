# Introduction

This project is simply a way to package up and distribute the POET Coding Standard which is defined in the
following project: [poet-coding-standard](https://github.com/POETGroup/poet-coding-standard)

This project does not attempt to do anything else.  If there are problems with the standard, then the problems should
be addressed in the `poet-coding-standard` project.  Once the problem is fixed, it can be synced from
`poet-coding-standard` into this project.

The sniffs check for the following:
 - the presence of ini_set in PHP files;
 - unconditional if statements;
 - FixMe or ToDo in code;
 - Ensuring the file ends with a newline;
 - byte order marks that may corrupt application work;
 - ensure each if statement is on a line by itself;
 - checks for no space after cast tokens;
 - all php keywords are lower case;
 - displays a message when any code prefixed with an ampersand is encountered;
 - checks to ensure that a file that declares new symbols does not cause any side effects;
 - arrays conform to the coding standard;
 - checks for the logical operators 'and' and 'or';
 - checks for alias and discouraged functions that are kept in php for compatability with older versions;
 - checks for eval;
 - looks for code that can never be executed;
 - looks for double quotes;
 - checks for slow functions in a loop;
 - checks for database portability;
 - looks for the use of RAWPARAM;
 - looks for the use of Superglobals;




# Install

Just add it to your project's `composer.json` file (`--dev` is optional based on your needs):

```
composer require --dev POETGroup/poet-coding-standard
```

# Usage

The following paths may change based on how things are installed, but basically you are looking for the path to
the CodeSniffer command and the path to the `moodle` directory of this project: 

```
vendor/bin/phpcs --standard=POET /path/to/moodle/plugin
```

# Credits

All praise should go to the contributors of
[poet-coding-standard](https://github.com/POETGroup/poet-coding-standard)

# License

This project is licensed under the GNU GPL v3 or later.  See the [LICENSE](LICENSE) file for details.
