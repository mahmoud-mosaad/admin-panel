<?php

require_once 'app/entity/Contact.php';
require_once 'app/entity/Category.php';
require_once 'app/entity/About.php';
require_once 'app/entity/User.php';

require_once 'app/database/connection.php';
require_once 'app/database/QueryBuilder.php';

require_once 'app/config/mail.php';

require_once 'app/model/ContactModel.php';
require_once 'app/model/AboutModel.php';
require_once "app/model/UserModel.php";
require_once 'app/model/CategoryModel.php';

require_once 'app/controller/Controller.php';
require_once 'app/controller/UserController.php';
require_once 'app/controller/CategoryController.php';
require_once 'app/controller/ContactController.php';
require_once 'app/controller/AboutController.php';

require_once 'config.php';
