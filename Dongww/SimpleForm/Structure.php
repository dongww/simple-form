<?php
/**
 * User: dongww
 * Date: 14-8-4
 * Time: 上午9:40
 */

namespace Dongww\SimpleForm;

use Symfony\Component\Yaml\Parser;

class Structure
{
    protected $data;

    public function __construct(array $structure)
    {
        $this->data = $structure;
    }

    public static function createFromYaml($fileName)
    {
        $yaml = new Parser();
        $data = $yaml->parse(file_get_contents($fileName));

        return new self($data);
    }

    public static function createFromArray(array $structure)
    {
        return new self($structure);
    }

    /**
     * @return array
     */
    public function getStructure()
    {
        return $this->data;
    }
}
