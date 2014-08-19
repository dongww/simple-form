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

    /**
     * 从YAML格式的配置文件创建实例
     *
     * @param string $fileName
     *
     * @return Structure
     */
    public static function createFromYaml($fileName)
    {
        $yaml = new Parser();
        $data = $yaml->parse(file_get_contents($fileName));

        return new self($data);
    }

    /**
     * 从包含表单配置信息的数组创建实例
     *
     * @param array $structure
     *
     * @return Structure
     */
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

    public function getFormStructure($formName)
    {
        return isset($this->data['forms'][$formName])
            ? $this->data['forms'][$formName]
            : null;
    }

    /**
     * 转换为 Simple-db 的数据结构格式
     *
     * @return array
     */
    public function toSbDbStructure()
    {
        $data       = $this->data;
        $tableNames = [];
        $tables     = [];
        $many_many  = [];

        foreach ($data['forms'] as $formName => $form) {
            $tableNames[] = $formName;
        }

        foreach ($data['forms'] as $formName => $form) {
            if (isset($form['timestamp_able']) && (bool)$form['timestamp_able'] == true) {
                $tables[$formName]['timestamp_able'] = true;
            }

            if (isset($form['tree_able']) && (bool)$form['tree_able'] == true) {
                $tables[$formName]['tree_able'] = true;
            }

            $tables[$formName]['fields'] = $this->parseFields(
                $form,
                $formName,
                $tables,
                $tableNames,
                $many_many
            );
        }

        return [
            'tables'    => $tables,
            'many_many' => $many_many,
        ];
    }

    protected function parseFields($form, $formName, &$tables, $tableNames, &$many_many)
    {
        $fields = [];

        foreach ($form['fields'] as $FieldName => $field) {
            if (!in_array($FieldName, $tableNames)) {
                switch ($field['type']) {
                    case 'imagelist':
                        $fields[$FieldName]['type'] = 'array';
                        break;
                    default:
                        $fields[$FieldName]['type'] = $field['type'];
                }

                if (isset($field['required']) && (bool)$field['required'] == true) {
                    $fields[$FieldName]['required'] = true;
                }
            } else {
                if (isset($field['multiple']) && (bool)$field['multiple'] == true) {
                    $many_many[] = [$formName, $FieldName];
                } else {
                    $tables[$formName]['belong_to'][] = $FieldName;
                }
            }
        }

        return $fields;
    }
}
