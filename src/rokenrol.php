<?php
function низ()
{
    return func_get_args();
}

function разбиј($delim, $niz)
{
    return explode($delim, $niz);
}

function спој($glue, $niz)
{
    return implode($glue, $niz);
}