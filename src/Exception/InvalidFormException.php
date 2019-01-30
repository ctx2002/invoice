<?php
/**
 * Created by PhpStorm.
 * User: anru
 * Date: 30-Jan-19
 * Time: 7:00 PM
 */

namespace App\Exception;


class InvalidFormException extends \RuntimeException
{
    protected $form;
    public function __construct($message, $form = null)
    {
        parent::__construct($message);
        $this->form = $form;
    }
    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
}