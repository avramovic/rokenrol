<?php

namespace Avram\Rokenrol;

class CodeParser
{
    protected $azbuka = array(
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "ђ" => "đ",
        "е" => "e",
        "ж" => "ž",
        "з" => "z",
        "и" => "i",
        "ј" => "j",
        "к" => "k",
        "л" => "l",
        "љ" => "lj",
        "м" => "m",
        "н" => "n",
        "њ" => "nj",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "ћ" => "ć",
        "у" => "u",
        "ф" => "f",
        "х" => "h",
        "ц" => "c",
        "ч" => "č",
        "џ" => "dž",
        "ш" => "š",
        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Ђ" => "Đ",
        "Е" => "E",
        "Ж" => "Ž",
        "З" => "Z",
        "И" => "I",
        "Ј" => "J",
        "К" => "K",
        "Л" => "L",
        "Љ" => "LJ",
        "М" => "M",
        "Н" => "N",
        "Њ" => "NJ",
        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "Ћ" => "Ć",
        "У" => "U",
        "Ф" => "F",
        "Х" => "H",
        "Ц" => "C",
        "Ч" => "Č",
        "Џ" => "DŽ",
        "Ш" => "Š",
    );


    protected $keywords = [
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

    public function translit($text)
    {
        return str_replace(array_keys($this->azbuka), array_values($this->azbuka), $text);
    }


    public function translate($code)
    {
        $php = $code;

        foreach ($this->keywords as $cyr => $lat) {
            preg_match_all('/'.$cyr.'/six', $code, $globalMatches, PREG_SET_ORDER);
//            var_dump($globalMatches);
            foreach ($globalMatches as $matches) {
                if (empty($matches)) {
                    continue;
                }

                $toReplace   = array_shift($matches);
                $replaceWith = sprintf($lat, ...$matches);
                $php         = $this->str_replace($toReplace, $replaceWith, $php);
            }

        }

        return $php;
    }

    function str_replace($replace, $with, $string)
    {
        $result  = "";
        $outside = preg_split('/("[^"]*"|\'[^\']*\')/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
        while ($outside)
            $result .= str_replace($replace, $with, array_shift($outside)).array_shift($outside);
        return $result;
    }


}