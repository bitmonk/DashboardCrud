<?php

if ($_SESSION['currentid'] == true) {
  $sessionid = $_SESSION['currentid'];

} else {
  header("Location: sign-in.php");
}

 include_once('../database/config.php');

 $fetch_table = "SELECT * FROM products WHERE id = '$sessionid'";
 
 $fetch_table_query = mysqli_query($conn, $fetch_table);
 
?>
<div class="card-header pb-0">
              <h6>Product List</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Products</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10 ps-2">Stock</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Description</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-10">Action</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr>
                        <?php
                    while($row = mysqli_fetch_assoc($fetch_table_query)){
                        $productId = $row['p_id'];
                        echo $productId;
                        $productName = $row['p_name'];
                       $price = $row['price'];
                       $productImage = $row['p_image'];
                       $productDesc = $row['p_desc'];
                       $quantity = $row['quantity'];
                       $userId = $row['id'];
                        if($productImage == null){
                            $productImage = 'defaultproduct.png';
                        }
                        ?>

                    
                      <td>
                          <div class="d-flex px-2 py-1">
                          <div>
                            <img src="./products/<?php echo $productImage; ?>" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $productName; ?></h6>
                            </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $quantity; ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?php echo $price; ?></p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold"><?php echo $productDesc; ?></span>
                      </td>
                      <td class="align-middle">
                         <!-- Delete Form -->
                        <?php
                            if(isset($_POST['delete-product'])){
                                $toDelete = $_POST['productToDelete'];
                                $delete_query = "DELETE FROM products WHERE p_id = '$toDelete'";
                                $result = mysqli_query($conn, $delete_query);
                                if ($result) {
                                    // Redirect to refresh the page
                                    echo "<script>window.location.href='user-products.php';</script>";
                                } else {
                                    echo "Sorry, can't delete!";
                                }
                            }

                        
                        ?>
                       
                       <a href="edit-product.php?p_id=<?php echo $productId; ?>" class="btn btn-link text-primary font-weight-bold text-xs">Edit</a>

                         <form action="" method="post">

                         <input type="hidden" name="productToEdit" value="<?php echo $productId; ?>">
                         
                                
                                <input type="hidden" name="productToDelete" value="<?php echo $productId; ?>">
                                <button type="submit" name="delete-product" class="btn btn-link text-primary font-weight-bold text-xs" >
                                    Delete
                                </button>
                            </form>



                         
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            