<?php
/**
 * User: dongww
 * Date: 14-8-4
 * Time: 上午9:09
 */

namespace Dongww\SimpleForm;


interface FormInterface
{
    /**
     * @return mixed
     */
    public function createView();

    /**
     * @param array|object $data
     * @return mixed
     */
    public function store($data);
}
