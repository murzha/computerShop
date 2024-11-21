<?php

namespace app\controllers;

class ContactsController extends AppController {

    public function indexAction() {
        $brands = \R::find('brand', "LIMIT 10");

        $this->setMeta('Contacts', ' ', ' ');
        $this->setData(compact('brands'));
    }

}
