
    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../model/StartSession.php';
require_once '../model/UserList.php';
require_once '../model/FileManager.php';

$session = new StartSession();
$user = $session->get('user');

if(!($user && $user->has_role("Engineer") )) { 
    header('location: /'); 
    exit();
}
$id = $user->id;

$filelist = new FileList(array('users_id' =>$id));

if(isset($_GET['e'])) {
    $reterr = $_GET['e'];
} else {
    $reterr = 0;
}

$errors = array(
    0 => "<strong>Welcome!</strong> NetPivot conversion magic is happening with F5 version 11 configuration files only.",
    1 => "File is not a bigip.conf format",
    2 => "BIGPIPE or version 10 and older cannot be converted at this time",
    3 => "UNKNOWN file type. Cannot identify the version of F5 config file."
    );

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ('../engine/css.php');?>
        <title>NetPivot</title>  
    </head>
    <body>
    <?php include ('../engine/menu1.php');?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10 content">
            <div class="alert alert-<?= $reterr==0?"success":"danger" ?> fade-in">  
                <p class="text-<?= $reterr==0?"success":"danger" ?>"><?= $errors[$reterr]; ?></p>
                </div>  
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>F5 Configuration Converter</h4>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action='../engine/uploader.php' method="POST">
                        <div class="form-group">
                            <div class="col-sm-9 ">                                
                                <input type="file" class="filestyle" name="InputFile" id="InputFile" data-size="lg" required><br>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" value="Convert" class="btn btn-default btn-lg" >                            
                            </div>  
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <input id="Orphan" type="checkbox" checked autocomplete="off"> 
                                Convert Orphan Objects
                            </div>
                        </div>    
                        <?php 
                            if (isset($_GET['exist_file'])) {
                                $fallado = $_GET['exist_file'];
                                echo '<p class="text-danger">File '.$fallado .' already exists or exceed the maximum file size</p>';
                            }
                            if (isset($_GET['upload_error'])) {
                                $fallado = $_GET['upload_error'];
                                echo '<p class="text-danger">An error ocurred uploading the file, please try again or contact your administrator.</p>';
                            }
                        ?>                                               
                    </form><br>                    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Conversion Manager</h4></div>
                <div class="panel-body">
                    <form method="POST">   
                        <div class="table-responsive">
                        <table id="mytable" class="table table-bordred table-striped" data-toggle="bootgrid">
                            <tr class="active">
                               <th>Select</th>
                                <th>File Name</th>                            
                                <th>Options</th>
                                <th>Upload Date</th>
                                
                            </tr>
                        <tbody>
                        <?php 
                                if ($filelist->count > 0) { ?>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary btn-lg margin-set pull-right" value="View Conversion" title="View Conversion" formaction="content.php">                                                                                  
                                    </div><br><br><br>
                                    <?php
                                    foreach ($filelist->files as &$f) { ?>
                                        <tr>
                                            <td style="width: 5%"><input type="radio" name="uuid" value="<?= $f->uuid ?>" required /></td>
                                            <td style="width: 55%"><?= $f->filename ?></td>
                                            <td style="width: 20%">
                                                <a href="rename.php?file=<?= $f->uuid ?>">Rename</a>&nbsp;
                                                <a href="../engine/reprocess.php?file=<?= $f->uuid ?>">Reprocess</a>
                                            </td>
                                            <td style="width: 20%"><?= $f->upload_time ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-primary btn-lg margin-set pull-right" value="View Conversion" title="View Conversion" disabled="disabled">          
                                             </div><br><br><br>
                                             <p class="text-danger">No files uploaded yet.</p>
                                <?php } ?>
                        </tbody>
                        </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="pull-left footer">
        <p class="col-md-12">
            <hr class="divider">
        </p>
    </footer>
</body>
</html>
