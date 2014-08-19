<?php
/**
 * User: dongww
 * Date: 14-8-4
 * Time: 上午9:13
 */

namespace Dongww\SimpleForm;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form as SfForm;
use Dongww\Db\Doctrine\Dbal\Manager\Bean;
use Symfony\Component\Form\FormView;

class Form implements FormInterface
{
    protected $name;
    /** @var  FormFactoryInterface */
    protected $formFactory;
    /** @var  Structure */
    protected $structure;

    protected static $filedTypeMap = [
        'string'    => 'text',
        'integer'   => 'integer',
        'float'     => 'number',
        'text'      => 'textarea',
        'datetime'  => 'datetime',
        'date'      => 'date',
        'time'      => 'time',
        'boolean'   => 'checkbox',
        'image'     => 'file',
        'file'      => 'file',
        'imagelist' => 'imagelist',
        'video'     => 'url',
        'videos'    => 'videos',
        'html'      => 'html',
        'select'    => 'choice',
    ];

    /**
     * @param string $name
     * @param FormFactoryInterface $factory
     * @param Structure            $structure
     */
    public function __construct($name, FormFactoryInterface $factory, Structure $structure)
    {
        $this->setName($name);
        $this->setFormFactory($factory);
        $this->setStructure($structure);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setFormFactory(FormFactoryInterface $factory)
    {
        $this->formFactory = $factory;
    }

    public function setStructure(Structure $structure)
    {
        $this->structure = $structure;
    }

    /**
     * @return FormView
     */
    public function createView()
    {
        return $this->createForm()->createView();
    }

    /**
     * @param Bean $data
     *
     * @return SfForm
     */
    public function createForm(Bean $data = null)
    {
        $formBuilder   = $this->formFactory->createBuilder('form', $data);
        $formStructure = $this->structure->getFormStructure($this->name);

        foreach ($formStructure['fields'] as $name => $field) {
            if (!(isset($field['in_form']) ? $field['in_form'] : true)) {
                continue;
            }

            $type = in_array(
                $field['type'],
                self::$filedTypeMap
            ) ? self::$filedTypeMap[$field['type']] : self::$filedTypeMap['text'];

            $options = [
                'label'    => $field['label'],
                'required' => isset($field['required']) ? $field['required'] : false,
            ];


            $formBuilder->add($name, $type, $options);
        }

        return $formBuilder->getForm();
    }

    /**
     * @param Bean|array $data
     *
     * @return bool
     */
    public function store($data)
    {
        // TODO: Implement store() method.
    }
}
