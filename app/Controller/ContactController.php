<?php
namespace app\Controller;
use app\Model\ContactModel;
class ContactController extends Controller
{

    public function __construct()
    {
        parent::__construct(new ContactModel());
    }


}