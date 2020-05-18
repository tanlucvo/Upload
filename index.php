<?php
require_once './function.php';
require_once './config.php';

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['name'])) {
    header('Location: ./views/login.php');
} else {
    $user = $_SESSION['user'];
    $name = $_SESSION['name'];
}
if(isset($_SESSION['filedownload'])){
    readfile($_SESSION['filedownload']);
    unset($_SESSION['filedownload']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="./Content/Scripts/main.js"></script>
    <link rel="stylesheet" href="./Content/Styles/main.css">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light sticky-top" id="navbar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Navbar</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <form class="form-inline my-2 my-lg-0 search">
                <input class="form-control mr-auto p-3 mr-mb-0" type="search" placeholder="Search" aria-label="Search">
            </form>
            <div class="infor d-flex flex-row bd-highlight mb-3">
                <img src="./Content/Images/avatar.png" alt="">
                <p class="text-justify">admin</p>
                <a href="./views/logout.php">Đăng xuất</a>
            </div>
        </div>
    </nav>
    <?php
    $root = $_SERVER['DOCUMENT_ROOT'] . "/BuffaloDrive/Upload/files/" . $_SESSION['user'];
    // echo $_SERVER['HTTP_HOST'];
    $dirName = filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_STRING);
    $create = filter_input(INPUT_POST, 'create', FILTER_SANITIZE_STRING);
    $folder = filter_input(INPUT_POST, 'folderName', FILTER_SANITIZE_STRING);
    $url = $_SERVER['REQUEST_URI'];
    $back = 'http://localhost:8888' . '' . substr($url, 0, strrpos($url, '/'));
    if ($dirName) {
        $dir_path = $root . '/' . $dirName;
    } else {
        $dir_path = $root;
    }
    $mess = '';
    if (!file_exists($root)) {
        mkdir($root);
    }
    if ($create && $folder) {

        if (file_exists($dir_path . '/' . $folder)) {
            $mess = 'ton tai';
        } else {
            mkdir($dir_path . '/' . $folder);
            addFile($dir_path . '/' . $folder, $_SESSION['user'], $conn);
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
    $files = scandir($dir_path);
    ?>
    <div>
        <div class="row">
            <div class="sticky col-lg-3 col-sm-5 left" id="left">
                <div class="new d-flex" data-toggle="collapse" href="#multiCollapse" role="button" aria-expanded="false" aria-controls="multiCollapse">
                    <svg class="bi bi-folder-plus" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M9.828 4H2.19a1 1 0 00-.996 1.09l.637 7a1 1 0 00.995.91H9v1H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3h3.982a2 2 0 011.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0013.81 4H9.828zm-2.95-1.707L7.587 3H2.19c-.24 0-.47.042-.684.12L1.5 2.98a1 1 0 011-.98h3.672a1 1 0 01.707.293z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M13.5 10a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13v-1.5a.5.5 0 01.5-.5z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M13 12.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd" />
                    </svg>
                    <p>New</p>
                </div>
                <div class="collapse multi-collapse" id='multiCollapse'>
                    <a class="dropdown-item" href="#" id='newfile'>New File</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" id='newfolder'>New Folder</a>
                </div>
                <div class="recent d-flex">
                    <svg class="a-s-fa-Ha-pa" width="1em" height="1em" viewBox="0 0 24 24" fill="#000000" focusable="false">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path>
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path>
                    </svg>
                    <p>Recent</p>
                </div>
                <div class="my-drive d-flex">
                    <svg class="" width="24px" height="24px" viewBox="0 0 24 24" fill="#000000" focusable="false">
                        <path d="M19 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H5v-1h14v1zm0-3H5V4h14v13zm-9.35-2h5.83l1.39-2.77h-5.81zm7.22-3.47L13.65 6h-2.9L14 11.53zm-5.26-2.04l-1.45-2.52-3.03 5.51L8.6 15z"></path>
                    </svg>
                    <p class="d-inline">My Drive</p>
                </div>
                <div class="trash d-flex">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="#000000" focusable="false" class="undefined ">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
                        <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
                    </svg>
                    <p>Trash</p>
                </div>
                <hr>
                <div class="stored d-flex ">
                    <svg class="a-s-fa-Ha-pa" width="24px" height="24px" viewBox="0 0 24 24" focusable="false" fill="#000000">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 20h18v-4H3v4zm2-3h2v2H5v-2zM3 4v4h18V4H3zm4 3H5V5h2v2zm-4 7h18v-4H3v4zm2-3h2v2H5v-2z"></path>
                    </svg>
                    <div>
                        <p>Storage</p>
                        <p>100 MB used</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-sm-7 right" id="right">
                <?php require_once './views/userpage.php' ?>
            </div>
        </div>
    </div>
    <ul class='custom-menu'>
        <li class="delete" data-action="Delete">Delete</li>
        <li class="rename" data-action="Rename">Rename</li>
        <li class="download" data-action="Download"><a href="#">Download</a></li>
        <li class="share" data-action="Share">Share this file</li>
    </ul>
    <?php print_r($_SESSION) ?>
</body>

</html>