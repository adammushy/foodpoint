
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}


// iclude the connecting file to fetch data from DB
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}
;

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
 //    It checks if the $_GET['delete'] variable is set or not.
 // If it's set, it retrieves the product's ID to be deleted and assigns it to $delete_id.
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:products.php');
 
 }
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/adminstyles.css">
    <title>Admin Panel</title>

    <style>
    .side-menu {
       
        transition: transform 0.5s ease-in-out;
        transform: translateX(0);
      }
      .side-menu.active {

        transform: translateX(-200px);
      }
      ..container{
        
      }
      .container.active{
          width: 100%;
          margin: 10px;
      }
      .header{
        
      }
      .card:hover{
          background-color: red;
      }
      .header.active{
          width: 100%;
      }
      #menuBtn{
          border:4px black;
      }

      #menuBtn:hover{

          background-color: bisque;
      }
    </style>
</head>

<body>
<!-- <?php include '../components/admin_header.php' ?> -->
    <div class="side-menu" id="side-menu" style="display:block;">
        <div class="brand-name">
            <h1 onclick="toggleMenu()"><b>Misosi Point😋</b></h1>
        </div>
        
        <ul>
            <li><img src="../icons/dashboard.png" alt="">&nbsp; 
                  <span><a href="dashboard.php" style="text-decoration: none;">Dashboard</a></span> 
             </li>
            <li><img src="../icons/product.png" alt="" style="color: beige;">&nbsp;
                 <span><a href="products.php" style="text-decoration: none;">Products</a></span>
            </li>
            <li><img src="../icons/order.png" alt="">&nbsp;
                 <span><a href="placed_orders.php" style="text-decoration: none;">Orders</a></span>
            </li>
            <li><img src="../icons/admin.png" alt="">&nbsp;
                <span><a href="admin_accounts.php" style="text-decoration: none;">Admins</a></span> 
            </li>
            <li><img src="../icons/user.png" alt="">&nbsp;
                <span><a href="users_accounts.php" style="text-decoration: none;">Users</a></span> 
            </li>
            <li><img src="../icons/message.png" alt="">&nbsp; 
                 <span><a href="messages.php" style="text-decoration: none;">Messages</a></span>
            </li>
             <li><img src="../icons/logout.png" alt="">&nbsp;
            <span><a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" style="text-decoration: none;">Log out</a></span> 
            </li>
        </ul>
    </div>
    <div class="container">
              
        <div class="header" style="">
            
            <div class="nav">
            <div id="menuBtn" class="fa-2x fa-solid fa-bars" onclick="toggleMenu()" ></div>
  
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="../icons/search.png" alt=""></button>
                </div>
                <div class="user">
                    <!-- I CAN ADD PRODUCT FROM HERE -->
                    <div> </div>
                    <!-- <a href="#" class="btn">Add New</a> -->
                    <!-- <img src="../icons/notifications.png" alt=""> -->
                    <div class="img-case">
                        
                        <img src="../icons/user1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>Welcome</h1>
                        <p style=""><?= $fetch_profile['name'];   ?></p>
                        <h3><a href="update-profile.php" style="text-decoration: none; color:grey;">
                                Update Profile</a></h3>
                    </div>
                    <div class="icon-case">
                        <img src="../icons/admin.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <?php
                            $total_pendings = 0;
                            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                            $select_pendings->execute(['pending']);
                            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                                $total_pendings += $fetch_pendings['total_price'];
                            }
                        ?>
                        <h1>Tshs.</span><?= $total_pendings; ?><span>/-</span></h1>
                        <p>total pendings</p>
                        <h3><a href="placed_orders.php" style="text-decoration: none; color:grey;">
                            See Orders</a></h3>
                     
                    </div>
                    <div class="icon-case">
                        <img src="../icons/order.png" alt="">
                    </div>
                </div> 
                <div class="card">
                     <a href="placed_orders.php" style="text-decoration: none; color:grey;">
                     <div class="box">
                     <?php
                                $total_completes = 0;
                                $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                                $select_completes->execute(['completed']);
                                while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                                    $total_completes += $fetch_completes['total_price'];
                                }
                            ?>
                        <h1><span>Tshs.</span><?= $total_completes; ?><span>/-</span></h1>
                        <p>total completes</p>
                        <h3>
                        see orders </h3>
                    </div>
                    </a>
                    <div class="icon-case">
                        <img src="../icons/order.png" alt="">
                    </div>
                </div> 

                <div class="card">
                     <a href="placed_orders.php" style="text-decoration: none; color:grey;">
                     <div class="box">
                     <?php
                                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                                $select_orders->execute();
                                $numbers_of_orders = $select_orders->rowCount();
                            ?>
                        <h1><?= $numbers_of_orders ?></h1>
                        <p>total orders</p>
                        <h3>
                        see orders </h3>
                    </div>
                    </a>
                    <div class="icon-case">
                        <img src="../icons/order.png" alt="">
                    </div>
                </div> 
                
                <div class="card">
                    <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $numbers_of_products = $select_products->rowCount();
                    ?>

                        <h1><?= $numbers_of_products; ?></h1>
                        <p>products added</p>
                        <h3><a href="products.php" style="text-decoration: none; color:grey;">
                            See Products</a></h3>
                    </div>

                    <div class="icon-case">
                        <img src="../icons/product.png" alt="">
                    </div>
                </div>
                <div class="card">
                     <a href="users_accounts.php" style="text-decoration: none; color:grey;">
                     <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $numbers_of_users = $select_users->rowCount();
                    ?>
                        <h1><?= $numbers_of_users; ?></h1>
                        <p>users accounts</p>
                        <h3>
                        see users </h3>
                    </div>
                    </a>
                    <div class="icon-case">
                        <img src="../icons/user.png" alt="">
                    </div>
                </div> 
                
                <div class="card">
                <a href="admin_accounts.php" style="text-decoration: none; color:grey;">
                    <div class="box">
                     <?php
                            $select_admins = $conn->prepare("SELECT * FROM `admin`");
                            $select_admins->execute();
                            $numbers_of_admins = $select_admins->rowCount();
                        ?>
                        <h1><?= $numbers_of_admins; ?></h1>
                        <h3>admins</h3>
                        
                    </div>
                </a>
                    <div class="icon-case">
                         <img src="../icons/admin.png" alt="">
                        
                    </div>
                </div>

                <div class="card">
                <a href="admin_accounts.php" style="text-decoration: none; color:grey;">
                    <div class="box">
                    <?php
                            $select_messages = $conn->prepare("SELECT * FROM `messages`");
                            $select_messages->execute();
                            $numbers_of_messages = $select_messages->rowCount();
                        ?>
                    <h1><?= $numbers_of_messages; ?></h1>
                    <h3>new message</h3>
                        
                    </div>
                </a>
                    <div class="icon-case">
                         <img src="../icons/message.png" alt="">
                        
                    </div>
                </div>
               
                
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Recent Products</h2>
                        <a href="products.php" class="btn">View All</a>
                    </div>
                    <table>
                     
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Option</th>
                        </tr>

             <?php  
                    $show_products = $conn->prepare("SELECT * FROM `products`");
                    $show_products->execute();
                    if($show_products->rowCount() > 0){
                        while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
                ?>
                        <tr>
                            <td><?= $fetch_products['name']; ?></td>
                            <td><?= $fetch_products['category']; ?></td>
                            <td><span>Tshs.</span><?= $fetch_products['price']; ?><span>/-</span></td>
                            <td><a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="btn">View</a></td>
                        </tr>
                <?php
                        }
                        }else{
                        echo '<p class="empty">no products added yet!</p>';
                        }
                 ?>


                        <!-- <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr> -->
                        
                    </table>
                </div>
                <div class="new-students">
                    <div class="title">
                        <h2>New Users</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Phone</th>
                        </tr>
                <?php
                        $select_account = $conn->prepare("SELECT * FROM `users`");
                        $select_account->execute();
                        if($select_account->rowCount() > 0){
                            while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
                    ?>

                        <tr>
                            <td><img src="../icons/user1.png" alt=""></td>
                            <td><?= $fetch_accounts['name']; ?></td>
                            <td><?= $fetch_accounts['number'];?></td>
                        </tr>
                    <?php
                            }
                        }else{
                            echo '<p class="empty">no accounts available</p>';
                        }

                        ?>


<!-- 
                        <tr>
                            <td><img src="user.png" alt=""></td>
                            <td>John Steve Doe</td>
                            <td><img src="info.png" alt=""></td>
                        </tr>
                         -->

                    </table>
                </div>
            </div>
        </div>
    </div>
    
<script >
  function toggleMenu() {
        const menu = document.querySelector('.side-menu');
        const main = document.querySelector('.container');
        const hd =document.querySelector('.header');
        menu.classList.toggle('active');
        main.classList.toggle('active');
        hd.classList.toggle('active');
      }  
</script>

</body>

</html>