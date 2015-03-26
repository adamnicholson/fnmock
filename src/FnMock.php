<?php

namespace FnMock;

class FnMock
{
    protected static $mocks = [];

    public static function mock($name, callable $callback)
    {
        $tpl = <<<'PHP'
namespace {namespace} {
    if (!function_exists('{namespace}\{fname}')) {
        function {fname}() {
            $callback = \FnMock\FnMock::getFunctionMockCallback('{namespace}\{fname}');
            return $callback ? call_user_func_array($callback, func_get_args()) : call_user_func_array('\{fname}', func_get_args());
        }
    }
}
PHP;
        $nameParts = explode('\\', $name);

        $tpl = str_replace('{fname}', array_pop($nameParts), $tpl);
        $tpl = str_replace('{namespace}', implode('\\', $nameParts), $tpl);

        eval($tpl);

        self::setFunctionMockCallback($name, $callback);
    }

    public static function setFunctionMockCallback($name, callable $fun)
    {
        self::$mocks[$name] = $fun;
    }

    public static function getFunctionMockCallback($name)
    {
        return isset(self::$mocks[$name]) ? self::$mocks[$name] : null;
    }

    public static function reset()
    {
        self::$mocks = [];
    }
}
