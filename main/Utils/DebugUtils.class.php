<?php
/***************************************************************************
 *   Copyright (C) 2006-2007 by Anton E. Lebedevich                        *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

/**
 * @ingroup Utils
 **/
namespace Onphp;

final class DebugUtils extends StaticFactory
{
    private static $memoryAccumulator = 0;
    private static $currentMemory = null;
    private static $start = null;

    /**
     * Helper function for trace()
     * Format debug line
     */
    public static function traceLine($i, $line)
    {
        $error = '#' . $i . ($i < 10 ? ' ' : '');
        $error .= (isset($line['file']) ? ' ' . $line['file'] : '');
        $error .= (isset($line['line']) ? '(' . $line['line'] . '):' : '');
        $error .= (isset($line['class']) ? ' ' . $line['class'] : '');
        $error .= (isset($line['type']) ? $line['type'] : '');
        $error .= $line['function'];
        if (isset($line['args'])) {
            $error .= '(' . implode(', ', array_map(function($arg) {
                if (is_integer($arg)) {
                    return $arg;
                } elseif (is_string($arg)) {
                    return "'$arg'";
                } elseif (is_array($arg)) {
                    return 'Array';
                } elseif (is_object($arg)) {
                    return get_class($arg);
                } else {
                    return var_export($arg, true);
                }
            }, $line['args'])) . ')';
        }
        $error .= "\n";
        return $error;
    }

    /**
     * Pretty print debug backtrace
     */
    public static function trace()
    {
        foreach (debug_backtrace() as $i => $line) {
            echo static::traceLine($i, $line);
        }
    }

    /**
     * Pretty print Exception
     * @param \Exception $e
     */
    public static function edump($e, $return = false)
    {
        $error = "#E  " . __METHOD__ . '()';
        $dbt = debug_backtrace()[1] ?? debug_backtrace()[0];
        if (isset($dbt['file']) && isset($dbt['line'])) {
            $error .= ' ' . $dbt['file'] . '(' . $dbt['line'] . '): ';
        }
        if (isset($dbt['class'])) {
            $error .= $dbt['class'] . '->';
        }
        $error .= $dbt['function'] . '()';
        $error .= "\n";
        $error .= "#M  " . get_class($e) . '(' . $e->getMessage() . ")\n";
        foreach ($e->getTrace() as $i => $line) {
            $error .= static::traceLine($i, $line);
        }
        if ($return) {
            return $error;
        } else {
            echo $error;
        }
    }

    public static function el($vr, $prefix = null)
    {
        if ($prefix === null) {
            $trace = debug_backtrace();
            $prefix = basename($trace[0]['file']).':'.$trace[0]['line'];
        }

        error_log($prefix.': ' . var_export($vr, true));
    }

    public static function ev($vr, $prefix = null)
    {
        if ($prefix === null) {
            $trace = debug_backtrace();
            $prefix = basename($trace[0]['file']).':'.$trace[0]['line'];
        }

        echo
            '<pre>'
            .$prefix.': '.htmlspecialchars(var_export($vr, true))
            .'</pre>';
    }

    public static function ec($vr, $prefix = null)
    {
        if ($prefix === null) {
            $trace = debug_backtrace();
            $prefix = basename($trace[0]['file']).':'.$trace[0]['line'];
        }

        echo "\n".$prefix.': '.var_export($vr, true)."\n";
    }

    public static function eq(Query $query, $prefix = null)
    {
        if ($prefix === null) {
            $trace = debug_backtrace();
            $prefix = basename($trace[0]['file']).':'.$trace[0]['line'];
        }

        error_log(
            $prefix.": ".$query->toDialectString(
                DBPool::me()->getLink()->getDialect()
            )
        );
    }

    public static function microtime($mtime = null)
    {
        list($usec, $sec) = explode(' ', $mtime ?: microtime(), 2);
        return ((float) $usec + (float) $sec);
    }

    public static function start()
    {
        self::$start = microtime(true);
    }

    public static function mark()
    {
        return microtime(true) - self::$start;
    }

    public static function setMemoryCounter()
    {
        self::$currentMemory = memory_get_usage();
    }

    public static function addMemoryCounter()
    {
        self::$memoryAccumulator += memory_get_usage() - self::$currentMemory;
    }

    public static function getMemoryCounter()
    {
        return self::$memoryAccumulator;
    }

    public static function errorMav($message = null)
    {
        $uri =
             (
                 isset($_SERVER['HTTP_HOST'])
                 ? $_SERVER['HTTP_HOST']
                 : null
             )
             .(
                 isset($_SERVER['REQUEST_URI'])
                 ? $_SERVER['REQUEST_URI']
                 : null
             );

        return
            ModelAndView::create()->
            setView('error')->
            setModel(
                Model::create()->
                set(
                    'errorMessage',
                    ($message ? $message.': ' : null).$uri
                )
            );
    }
}
?>
