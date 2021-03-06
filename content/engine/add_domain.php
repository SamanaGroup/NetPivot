<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once dirname(__FILE__) .'/../model/StartSession.php';
require_once dirname(__FILE__) .'/../model/UserList.php';
require_once dirname(__FILE__) .'/../model/DomainList.php';
require_once dirname(__FILE__) .'/functions.php';

$session = new StartSession();
$user = $session->get('user');

$domainname = get_domain($_POST);

if(!($user && $user->has_role("System Admin"))) {
    header('location: ../');
    exit();
}
if(!isset($_POST['name']) || !isset($_POST['domain'])) {
	header('location: ../admin/admin_domains.php');
	exit();
}

$domain = new Domain($_POST);

$domain->save();

header('location: ../admin/admin_domains.php')

?>



