<?php
 include_once('../database/config.php');


  $fetch_table = "SELECT users.f_name, users.l_name, users.email, products.p_id, products.p_name, products.price, products.p_image, products.p_desc, products.quantity FROM users JOIN products ON users.id = products.id";

 $fetch_table_query = mysqli_query($conn, $fetch_table);

//  $result = mysqli_fetch_array($fetch_table_query, MYSQLI_ASSOC);
//  while ($result = mysqli_fetch_array($fetch_table_query, MYSQLI_ASSOC)) {
//   print_r($result);
// }


?>
<div class="card-header pb-0">
              <h6>Product Lists</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Users</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Products</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Stock</th>
                      <th class="text-secondary opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr>
                        <?php
                    while($result = mysqli_fetch_assoc($fetch_table_query)){
                        $productId = $result['p_id'];
                        $fullName = $result['f_name']." ".$result['l_name'];
                       $email = $result['email'];
                       $productName = $result['p_name'];
                       $productDesc = $result['p_desc'];
                       $productPrice = $result['price'];
                       $quantity = $result['quantity'];

                       $productImage = $result['p_image'];
                        if($productImage == null){
                            $productImage = 'defaultproduct.png';
                        }
                        ?>
                        <td>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $fullName; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $email; ?></p>
                          </div>
                        
                      </td>
                      <td>
                        
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="./products/<?php echo $productImage; ?>" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $productName; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $productDesc; ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                      <h6 class="mb-0 text-sm"><?php echo "$$productPrice"; ?></h6>

                      </td>
                      <td class="align-middle text-center">
                      <h6 class="mb-0 text-sm"><?php echo $quantity; ?></h6>
                    </td>
                      <td class="align-middle">
                         <!-- Delete Form -->
                        <?php 
                            if(isset($_POST['deleteProduct'])){
                                $toDelete = $_POST['productToDelete'];
                                $delete_query = "DELETE FROM products WHERE p_id = '$toDelete'";
                                $result = mysqli_query($conn, $delete_query);
                                if ($result) {
                                    // Redirect to refresh the page
                                    echo "<script>window.location.href='admin-products.php';</script>";
                                } else {
                                    echo "Sorry, can't delete!";
                                }
                            }
                        ?>

                         <form action="" method="post">
                                <input type="hidden" name="productToDelete" value="<?php echo $productId; ?>">
                                <button type="submit" name="editProduct" class="btn btn-link text-secondary font-weight-bold text-xs">
                                <a href='admin-edit-product.php?id=<?php echo $productId; ?>'>Edit</a>
                                </button>
                                <button type="submit" name="deleteProduct" class="btn btn-link text-secondary font-weight-bold text-xs" onclick="window.location.reload()">
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

            