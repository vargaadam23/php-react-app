<?php

namespace testassignment;

/*
    This is the controller interface wich is implemented by all other controllers,
    All the controllers have to implemenet Get, Post And Delete functionalities
*/

abstract class Controller
{
    abstract public function handleGet();

    abstract public function handlePost();

    abstract public function handleDelete();
}

?>