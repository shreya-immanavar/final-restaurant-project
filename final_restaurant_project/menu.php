<?php include "header.php"; ?>

<section class="menu-section" style="padding: 40px 0;">
    <div class="wrap">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <h2 style="margin-bottom:0;">Our Premium Menu</h2>
            <a href="<?php echo BASE_URL; ?>add_menu_item.php" class="btn btn-primary">⚡ Add New Menu Item</a>
        </div>

        <?php
        include_once "db.php";
        $result = mysqli_query($conn, "SELECT mi.*, r.name as restaurant_name FROM menu_item mi JOIN restaurant r ON mi.restaurant_id = r.restaurant_id ORDER BY r.name, mi.item_name");

        if(mysqli_num_rows($result) > 0):
        ?>
        <div class="orders-container" style="background:var(--color-surface); padding:20px; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow-x:auto;">
            <table class="orders-table" style="width:100%; border-collapse:separate; border-spacing:0;">
                <thead>
                    <tr style="background:var(--color-surface-soft);">
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">ID</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">Restaurant</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">Image</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">Item Name</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">Description</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700;">Price</th>
                        <th style="padding:15px; border-bottom:2px solid var(--color-border); font-weight:700; text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr style="transition:var(--transition-smooth); border-bottom:1px solid var(--color-border);">
                        <td style="padding:15px; border-bottom:1px solid var(--color-border); color:var(--color-text-muted); font-weight:600;">
                            #<?php echo str_pad($row['item_id'], 4, "0", STR_PAD_LEFT); ?>
                        </td>
                        <td style="padding:15px; border-bottom:1px solid var(--color-border); font-weight:600;">
                            <?php echo htmlspecialchars($row['restaurant_name']); ?>
                        </td>
                        <td style="padding:15px; border-bottom:1px solid var(--color-border);">
                            <?php 
                            $image_path = 'assets/images/menu/' . $row['image'];
                            if($row['image'] && file_exists($image_path)): 
                            ?>
                                <img src="<?php echo BASE_URL . $image_path; ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>" style="width:70px; height:50px; object-fit:cover; border-radius:var(--radius-sm); box-shadow:var(--shadow-sm);">
                            <?php else: ?>
                                <div style="width:70px; height:50px; background:var(--color-surface-soft); border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; color:var(--color-text-muted); font-weight:bold; font-size:1.1em;">
                                    <?php echo htmlspecialchars(substr($row['item_name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding:15px; border-bottom:1px solid var(--color-border); font-weight:700; color:var(--color-primary);">
                            <?php echo htmlspecialchars($row['item_name']); ?>
                        </td>
                        <td style="padding:15px; border-bottom:1px solid var(--color-border); color:var(--color-text-muted); max-width:250px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </td>
                        <td class="price">
                            ₹<?php echo number_format($row['price'], 2); ?>
                        </td>
                        <td style="padding:15px; border-bottom:1px solid var(--color-border); text-align:center;">
                            <div style="display:flex; gap:8px; justify-content:center;">
                                <a href="<?php echo BASE_URL; ?>add_menu_item.php?edit_id=<?php echo $row['item_id']; ?>" class="btn btn-sm btn-secondary" style="padding: 6px 12px; font-size: 12px; display:inline-flex;">Edit</a>
                                <a href="<?php echo BASE_URL; ?>delete_menu_item.php?id=<?php echo $row['item_id']; ?>" class="btn btn-sm btn-danger" style="padding: 6px 12px; font-size: 12px; display:inline-flex;" onclick="return confirm('Are you sure you want to delete this menu item?')">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div style="text-align:center; padding:50px; background:var(--color-surface); border-radius:var(--radius-lg); box-shadow:var(--shadow-sm);">
            <h3 style="color:var(--color-text-muted);">No menu items found.</h3>
            <p style="margin: 15px 0; color:var(--color-text-muted);">Start by creating your first delicious menu item.</p>
            <a href="<?php echo BASE_URL; ?>add_menu_item.php" class="btn btn-primary">Add First Menu Item</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include "footer.php"; ?>
