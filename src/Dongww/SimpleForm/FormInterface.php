<?php
/**
 * User: dongww
 * Date: 14-8-4
 * Time: 上午9:09
 */

namespace Dongww\SimpleForm;

use Symfony\Component\Form\FormView;

interface FormInterface
{
    /**
     * @return FormView
     */
    public function createView();

    /**
     * @param  array|object $data
     *
     * @return bool
     */
    public function store($data);
}
