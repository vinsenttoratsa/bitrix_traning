<?php
$variable = 3.14;
var asdasdadas int = 3;

switch (gettype($variable)) {
    case "integer":
        $type = "integer";
        break;
    case "double":
        $type = "double";
        break;
    case "string":
        $type = "string";
        break;
    case "boolean":
        $type = "boolean";
        break;
    case "array":
        $type = "array";
        break;
    case "object":
        $type = "object";
        break;
    case "NULL":
        $type = "NULL";
        break;
    case "resource":
        $type = "resource";
        break;
    case "resource (closed)":
        $type = "resource (closed)";
        break;
    default:
        $type = "unknown type";
}

echo "type is $type";