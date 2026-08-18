<?php

class SQL_security {

  
// Your clear string function
public function get_clear_string($get_string_to_clear) {
    $search = array(
        "'",  // Single quote
        '"',  // Double quote
//        '\\', // Backslash
        '%',  // Percent
//        '_',  // Underscore
        ';',  // Semicolon
        '-',  // Dash
        '*',  // Asterisk
        '=',  // Equal sign
        '>',  // Greater than
        '<',  // Less than
        '&',  // Ampersand
        '|',  // Vertical bar
        '!',  // Exclamation mark
        '@',  // At symbol
        '^',  // Caret
        '$',  // Dollar sign
        '(',  // Left parenthesis
        ')',  // Right parenthesis
        '{',  // Left brace
        '}',  // Right brace
        '[',  // Left bracket
        ']'   // Right bracket
    );

    $replace = array(
        "\\'",  // Escaped single quote
        '\\"',  // Escaped double quote
//        '\\\\', // Escaped backslash
        '\\%',  // Escaped percent
//        '\\_',  // Escaped underscore
        '\\;',  // Escaped semicolon
        '\\-',  // Escaped dash
        '\\*',  // Escaped asterisk
        '\\=',  // Escaped equal sign
        '\\>',  // Escaped greater than
        '\\<',  // Escaped less than
        'and',  // Replace ampersand with 'and'
        '\\|',  // Escaped vertical bar
        '\\!',  // Escaped exclamation mark
        '\\@',  // Escaped at symbol
        '\\^',  // Escaped caret
        '\\$',  // Escaped dollar sign
        '\\(',  // Escaped left parenthesis
        '\\)',  // Escaped right parenthesis
        '\\{',  // Escaped left brace
        '\\}',  // Escaped right brace
        '\\[',  // Escaped left bracket
        '\\]'   // Escaped right bracket
    );

    $safe_string = str_replace($search, $replace, $get_string_to_clear);
    return $safe_string;
}}

//// Assign paragraph to a variable
//$test_paragraph = "Hello! Welcome to Neo Solution @ Wattala. 
//Please review these symbols: %, &, *, $, ( ), [ ], { }, ^, |, !, ', \", <, >, =, \, ;, -, _.
//Your total is \$50. Are you okay with that? Click 'OK' or say \"No\" to proceed. 
//We strive to improve & reward God.";
//
//// Create an instance of the class containing the function and call it
//$class_instance = new YourClass(); // Replace with the actual class name
//$safe_paragraph = $class_instance->get_clear_string($test_paragraph);
//
//// Print the result
//echo $safe_paragraph;

