<?php

function categoryIndex()
{
    $view = 'categorys/table';
    $title = 'Category';

    $page = $GLOBALS['page'];
    $limit = 10;
    $initial_page = ($page - 1) * $limit;
    $data = getAllCategory($limit, $initial_page);
    $total_rows = getTotalPageCategory();
    $total_pages = ceil($total_rows / $limit);

    require_once VIEW_ADMIN . 'layouts/master.php';
}

function categoryCreate()
{
    $title = 'Create';
    $view = 'categorys/create';
    $script = 'category';


    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        $image = $_FILES['image'];

        if (empty($name)) {
            $_SESSION['errors']['name'] = 'Vui lòng nhập name';
        } else {
            unset($_SESSION['errors']['name']);
        }

        if (empty($slug)) {
            $_SESSION['errors']['slug'] = 'Vui lòng nhập link thân thiện';
        } else {
            unset($_SESSION['errors']['slug']);
        }

        if (empty($image['name'])) {
            $_SESSION['errors']['image'] = 'Vui lòng tải image';
        } else {
            unset($_SESSION['errors']['image']);
        }

        if (!empty($_SESSION['errors'])) {
            header('location: ' . BASE_URL_ADMIN . '?act=add-category');
        } else {
            $image = upload_file($image, 'public/image/');
            insertCategory($name, $slug, $image);
            header("location: " . BASE_URL_ADMIN . "?act=categorys");
        }
    }

    require_once VIEW_ADMIN . 'layouts/master.php';
}

function categoryUpdate()
{
    $title = 'Update';
    $view = 'categorys/update';
    $id = $_GET['id'] ?? null;
    $category = selectOneCategory($id);

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        if (empty($name)) {
            $_SESSION['errors']['name'] = 'Vui lòng nhập name category';
        } else {
            unset($_SESSION['errors']['name']);
        }

        if (!empty($_SESSION['errors'])) {
            header('location: ' . BASE_URL_ADMIN . '?act=update-category&id=' . $id);
        } else {
            updateCategory($id, $name);
            header('location: ' . BASE_URL_ADMIN . '?act=categorys');
        }
    }


    require_once VIEW_ADMIN . 'layouts/master.php';
}

function categoryShow()
{
    $title = 'Show';
    $view = 'categorys/show';
    $id = $_GET['id'] ?? null;
    $category = selectOneCategory($id);

    require_once VIEW_ADMIN . "layouts/master.php";
}

function categoryDelete()
{
    $id = $_GET['id'] ?? null;
    deleteCategory($id);
    header('location: ' . BASE_URL_ADMIN . '?act=categorys');
}
