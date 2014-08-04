<?php
/**
 * User: dongww
 * Date: 14-8-4
 * Time: 上午9:13
 */

namespace Dongww\SimpleForm;

use Symfony\Component\Form\FormFactoryInterface;
use Dongww\Db\Doctrine\Dbal\Manager\Bean;

class Form implements FormInterface
{
    protected $formFactory;
    protected $structure;

    /**
     * @param FormFactoryInterface $factory
     * @param Structure            $structure
     */
    public function __construct(FormFactoryInterface $factory, Structure $structure)
    {
        $this->setFormFactory($factory);
        $this->setStructure($structure);
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
     * @return mixed
     */
    public function createView()
    {
        return $this->getForm()->createView();
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {

    }

    /**
     * @param Bean|array $data
     * @return mixed
     */
    public function store($data)
    {
        // TODO: Implement store() method.
    }
}
