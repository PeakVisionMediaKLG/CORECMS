<?php
namespace CORE;
class two
{
    function test_two()
    {}
}

class three extends two
{
    static function tester()
    {
        echo "bla";
    }
}
?>