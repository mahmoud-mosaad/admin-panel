<?php

class ContactController extends Controller
{

    public function __construct()
    {
        parent::__construct(new ContactModel());
    }


}