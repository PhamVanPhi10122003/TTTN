<?php 
include "class/cartegory_class.php";  
session_start(); 

if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {     
    header("Location: ../view/login.php");     
    exit(); 
}  

$cartegory = new Cartegory;  

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {     
    $cartegory_id = $_GET['cartegory_id'];     
    $delete_cartegory = $cartegory->delete_cartegory($cartegory_id);     
    echo "<script>alert('Xóa danh mục thành công!'); window.location.href = 'cartegorylist.php';</script>";     
    exit(); 
}  

if (isset($_GET['cartegory_id'])) {     
    $cartegory_id = $_GET['cartegory_id']; 
?>     
    <script>         
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {             
            window.location.href = 'cartegorydelete.php?confirm_delete=1&cartegory_id=<?php echo $cartegory_id; ?>';         
        } else {             
            window.location.href = 'cartegorylist.php';         
        }     
    </script> 
<?php 
} 
?>
