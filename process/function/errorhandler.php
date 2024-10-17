<?php

// Set error reporting level
error_reporting(E_ALL);

// Custom error handler function
function errorHandler($severity, $message, $file, $line)
{
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}

// Set custom error handler
set_error_handler("errorHandler");

// Custom exception handler function
function exceptionHandler($exception)
{
    // Log the exception
    error_log($exception);


    header("Location: error-500.php");
    exit;
}

// Set custom exception handler
set_exception_handler("exceptionHandler");
?>