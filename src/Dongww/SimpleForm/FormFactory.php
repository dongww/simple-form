<?php
/**
 * User: dongww
 * Date: 14-8-6
 * Time: 上午9:33
 */

namespace Dongww\SimpleForm;

use Symfony\Component\Form\FormFactoryInterface;

class FormFactory
{
    protected $sfFormFactory;
    protected $structure;

    public function __construct(FormFactoryInterface $factory, Structure $structure)
    {
        $this->setFormFactory($factory);
        $this->setStructure($structure);
    }

    /**
     * @param  string $name
     *
     * @return FormInterface
     */
    public function createForm($name)
    {
        return new Form($name, $this->sfFormFactory, $this->structure);
    }

    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->sfFormFactory = $formFactory;
    }

    public function setStructure(Structure $structure)
    {
        $this->structure = $structure;
    }
}
