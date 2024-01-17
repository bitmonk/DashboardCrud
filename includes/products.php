<?php
 include_once('../database/config.php');
 $fetch_table = "SELECT * FROM products";
 
 $fetch_table_query = mysqli_query($conn, $fetch_table);
 
?>
<div class="card-header pb-0">
              <h6>Manage Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Users</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Position</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr>
                        <?php
                    while($row = mysqli_fetch_assoc($fetch_table_query)){
                        $user_id = $row['id'];
                        $user_name = $row['f_name']." ".$row['l_name'];
                       $user_email = $row['email'];
                       $user_image = $row['image'];
                        if($user_image == null){
                            $user_image = 'profile.png';
                        }

                        ?>

                    
<td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="./uploads/<?php echo $user_image; ?>" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $user_name; ?></h6>
                            <p class="text-xs text-secondary mb-0"><?php echo $user_email; ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                        <p class="text-xs text-secondary mb-0">Organization</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                      </td>
                      <td class="align-middle">
                         <!-- Delete Form -->
                        <?php
                            if(isset($_POST['delete_user'])){
                                $toDelete = $_POST['user_id_to_delete'];
                                $delete_query = "DELETE FROM users WHERE id = '$toDelete'";
                                $result = mysqli_query($conn, $delete_query);
                                if ($result) {
                                    // Redirect to refresh the page
                                    echo "<script>window.location.href='tables.php';</script>";
                                } else {
                                    echo "Sorry, can't delete!";
                                }
                            }
                        ?>

                         <form action="" method="post">
                                <input type="hidden" name="user_id_to_delete" value="<?php echo $user_id; ?>">
                                <button type="submit" name="delete_user" class="btn btn-link text-secondary font-weight-bold text-xs" onclick="window.location.reload()">
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

            