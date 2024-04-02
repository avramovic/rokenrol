<?php

namespace Avram\Rokenrol;

use Avram\Rokenrol\Interfaces\ICodeParserInterface;

class CodeParser implements ICodeParserInterface
{

    protected array $keywords = [
        'за\s*\('           => 'for (',
        'засваки\s*\('      => 'foreach (',
        'докје\s*\('        => 'while (',
        'акоје\s*\('        => 'if (',
        'илиакоје\s*\('     => 'elseif (',
        'иначе\s*'          => 'else ',
        'усупротном\s*'     => 'else ',
        'пиши\s*\(?'        => 'echo ',
        'прикажи\s*\(?'     => 'echo ',
        'рођење\s*\('       => '__construct(',
        'функција\s*'       => 'function ',
        'јавна\s*'          => 'public ',
        'јавно\s*'          => 'public ',
        'приватна\s*'       => 'private ',
        'приватно\s*'       => 'private ',
        'заштићена\s*'      => 'protected ',
        'заштићено\s*'      => 'protected ',
        'статична\s*'       => 'static ',
        'апстрактна\s*'     => 'abstract ',
        'врати\s*'          => 'return ',
        'неистина'          => 'false',
        'истина'            => 'true',
        'задовољава\s*'     => 'implements ',
        'имплементира\s*'   => 'implements ',
        'интерфејс\s*'      => 'interface ',
        'особина\s*'        => 'trait ',
        'класа\s*'          => 'class ',
        'ново\s*'           => 'new ',
        'нова\s*'           => 'new ',
        'нов\s*'            => 'new ',
        '\s+као\s+€'        => ' as $',
        'баци\s*'           => 'throw ',
        'наслеђује\s*'      => 'extends ',
        'прекини\s*(\d?)'   => 'break %s',
        'настави\s*(\d?)'   => 'continue %s',
        '€([а-яА-Яцуи_]+)'  => '$%s',
        '$([а-яА-Яцуи_]+)'  => '$%s',
        '->([а-яА-Яцуи_]+)' => '->%s',
        'НОВИРЕД'           => 'PHP_EOL',
    ];

    public function parse(string $code): string
    {
        $php = $code;

        foreach ($this->keywords as $cyr => $lat) {
            preg_match_all('/'.$cyr.'/six', $code, $globalMatches, PREG_SET_ORDER);
            foreach ($globalMatches as $matches) {
                if (empty($matches)) {
                    continue;
                }

                $toReplace   = array_shift($matches);
                $replaceWith = sprintf($lat, ...$matches);
                $php         = $this->replaceOutsideQuotes($toReplace, $replaceWith, $php);
            }

        }

        return $php;
    }

    protected function replaceOutsideQuotes(string $replace, string $with, string $string): string
    {
        $result  = "";
        $outside = preg_split('/("[^"]*"|\'[^\']*\')/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        while ($outside)
            $result .= str_replace($replace, $with, array_shift($outside)).array_shift($outside);
        return $result;
    }

}