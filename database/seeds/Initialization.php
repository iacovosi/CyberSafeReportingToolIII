<?php

use Illuminate\Database\Seeder;

class Initialization extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        $users = array(
            ['id' => 1, 'name' => 'admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'manager', 'email' => 'manager@manager.com', 'password' => bcrypt('manager'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'Nicolas Kanaris', 'email' => 'kanaris.n@cyearn.pi.ac.cy', 'password' => bcrypt('Ab123456!'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 4, 'name' => 'Anastasia Economou', 'email' => 'anasta@cyearn.pi.ac.cy', 'password' => bcrypt('Ab123456!'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 5, 'name' => 'Pambos Nicolaou', 'email' => 'nicolaou.p@cyearn.pi.ac.cy', 'password' => bcrypt('Ab123456!'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 6, 'name' => 'Panayiota Hadjittofi', 'email' => 'hadjittofi.p@cyearn.pi.ac.cy', 'password' => bcrypt('Ab123456!'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 7, 'name' => 'Giorgos Poyiadjis', 'email' => 'poyiadjis.g@cyearn.pi.ac.cy', 'password' => bcrypt('Ab123456!'), 'created_at' => new DateTime, 'updated_at' => new DateTime],
        );
        DB::table('users')->insert($users);

        DB::table('roles')->delete();
        $roles = array(
            ['id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrative privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'manager', 'display_name' => 'Manager', 'description' => 'Manager privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'operator', 'display_name' => 'Operator', 'description' => 'Helpline & Hotline privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 4, 'name' => 'helpline', 'display_name' => 'Helpline', 'description' => 'Helpline privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 5, 'name' => 'support', 'display_name' => 'Support', 'description' => 'Support privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 6, 'name' => 'hotline', 'display_name' => 'Hotline', 'description' => 'Hotline privileges', 'created_at' => new DateTime, 'updated_at' => new DateTime],            
        );
        DB::table('roles')->insert($roles);

        DB::table('role_user')->delete();
        $role_user = array(
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
            ['user_id' => 3, 'role_id' => 1],
            ['user_id' => 4, 'role_id' => 2],
            ['user_id' => 5, 'role_id' => 3],
            ['user_id' => 6, 'role_id' => 3],
            ['user_id' => 7, 'role_id' => 3],
        );
        DB::table('role_user')->insert($role_user);

        DB::table('permissions')->delete();
        $permissions = array(
            ['id' => 1, 'name' => 'view', 'display_name' => 'View ', 'description' => 'Can View', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'create', 'display_name' => 'Create ', 'description' => 'Can Create', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'edit', 'display_name' => 'Edit', 'description' => 'Can Edit', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 4, 'name' => 'delete', 'display_name' => 'Delete', 'description' => 'Can Delete', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        );
        DB::table('permissions')->insert($permissions);

        DB::table('permission_role')->delete();
        $permissionsrole = array(
            ['permission_id' => 1, 'role_id' => '1'],
            ['permission_id' => 2, 'role_id' => '1'],
            ['permission_id' => 3, 'role_id' => '1'],
        );
        DB::table('permission_role')->insert($permissionsrole);

        DB::table('groups')->delete();
        $groups = array(
            ['id' => 1, 'name' => 'settings','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2, 'name' => 'users','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3, 'name' => 'roles','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4, 'name' => 'permissions','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 5, 'name' => 'content','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 6, 'name' => 'helpline','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 7, 'name' => 'hotline','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 8, 'name' => 'statistics','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 9, 'name' => 'chat','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 10, 'name' => 'managers','created_at'=> new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('groups')->insert($groups);

        DB::table('group_permissions')->delete();
        $group_permissions = array(
            // Admin
            ['id' => 1, 'user_id' => 1,'permission_id'=> 1,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2, 'user_id' => 1,'permission_id'=> 2,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3, 'user_id' => 1,'permission_id'=> 3,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4, 'user_id' => 1,'permission_id'=> 4,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 5, 'user_id' => 1,'permission_id'=> 1,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 6, 'user_id' => 1,'permission_id'=> 2,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 7, 'user_id' => 1,'permission_id'=> 3,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 8, 'user_id' => 1,'permission_id'=> 4,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 9, 'user_id' => 1,'permission_id'=> 1,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 10, 'user_id' => 1,'permission_id'=> 2,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 11, 'user_id' => 1,'permission_id'=> 3,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 12, 'user_id' => 1,'permission_id'=> 4,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 13, 'user_id' => 1,'permission_id'=> 1,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 14, 'user_id' => 1,'permission_id'=> 2,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 15, 'user_id' => 1,'permission_id'=> 3,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 16, 'user_id' => 1,'permission_id'=> 4,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 17, 'user_id' => 1,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 18, 'user_id' => 1,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 19, 'user_id' => 1,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 20, 'user_id' => 1,'permission_id'=> 4,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 21, 'user_id' => 1,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 22, 'user_id' => 1,'permission_id'=> 2,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 23, 'user_id' => 1,'permission_id'=> 3,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 24, 'user_id' => 1,'permission_id'=> 4,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 25, 'user_id' => 1,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 26, 'user_id' => 1,'permission_id'=> 2,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 27, 'user_id' => 1,'permission_id'=> 3,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 28, 'user_id' => 1,'permission_id'=> 4,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 29, 'user_id' => 1,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // ['id' => 30, 'user_id' => 1,'permission_id'=> 1,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Manager
            ['id' => 50, 'user_id' => 2,'permission_id'=> 1,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 51, 'user_id' => 2,'permission_id'=> 2,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 52, 'user_id' => 2,'permission_id'=> 3,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 53, 'user_id' => 2,'permission_id'=> 4,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 54, 'user_id' => 2,'permission_id'=> 1,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 55, 'user_id' => 2,'permission_id'=> 2,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 56, 'user_id' => 2,'permission_id'=> 3,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 57, 'user_id' => 2,'permission_id'=> 4,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 58, 'user_id' => 2,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 59, 'user_id' => 2,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 60, 'user_id' => 2,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 61, 'user_id' => 2,'permission_id'=> 4,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Admin - Kanaris
            ['id' => 101, 'user_id' => 3,'permission_id'=> 1,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 102, 'user_id' => 3,'permission_id'=> 2,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 103, 'user_id' => 3,'permission_id'=> 3,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 104, 'user_id' => 3,'permission_id'=> 4,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 105, 'user_id' => 3,'permission_id'=> 1,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 106, 'user_id' => 3,'permission_id'=> 2,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 107, 'user_id' => 3,'permission_id'=> 3,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 108, 'user_id' => 3,'permission_id'=> 4,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 109, 'user_id' => 3,'permission_id'=> 1,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 110, 'user_id' => 3,'permission_id'=> 2,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 111, 'user_id' => 3,'permission_id'=> 3,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 112, 'user_id' => 3,'permission_id'=> 4,'group_id' => 3,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 113, 'user_id' => 3,'permission_id'=> 1,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 114, 'user_id' => 3,'permission_id'=> 2,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 115, 'user_id' => 3,'permission_id'=> 3,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 116, 'user_id' => 3,'permission_id'=> 4,'group_id' => 4,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 117, 'user_id' => 3,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 118, 'user_id' => 3,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 119, 'user_id' => 3,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 120, 'user_id' => 3,'permission_id'=> 4,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 121, 'user_id' => 3,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 122, 'user_id' => 3,'permission_id'=> 2,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 123, 'user_id' => 3,'permission_id'=> 3,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 124, 'user_id' => 3,'permission_id'=> 4,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 125, 'user_id' => 3,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 126, 'user_id' => 3,'permission_id'=> 2,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 127, 'user_id' => 3,'permission_id'=> 3,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 128, 'user_id' => 3,'permission_id'=> 4,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 129, 'user_id' => 3,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // ['id' => 130, 'user_id' => 3,'permission_id'=> 1,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Manager - Anasta
            ['id' => 250, 'user_id' => 4,'permission_id'=> 1,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 251, 'user_id' => 4,'permission_id'=> 2,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 252, 'user_id' => 4,'permission_id'=> 3,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 253, 'user_id' => 4,'permission_id'=> 4,'group_id' => 1,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 254, 'user_id' => 4,'permission_id'=> 1,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 255, 'user_id' => 4,'permission_id'=> 2,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 256, 'user_id' => 4,'permission_id'=> 3,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 257, 'user_id' => 4,'permission_id'=> 4,'group_id' => 2,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 258, 'user_id' => 4,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 259, 'user_id' => 4,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 260, 'user_id' => 4,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 261, 'user_id' => 4,'permission_id'=> 4,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 262, 'user_id' => 4,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 263, 'user_id' => 4,'permission_id'=> 4,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 264, 'user_id' => 4,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 265, 'user_id' => 4,'permission_id'=> 4,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 266, 'user_id' => 4,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Operator 1 - Hotline Only
            ['id' => 551, 'user_id' => 5,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 552, 'user_id' => 5,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 553, 'user_id' => 5,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 561, 'user_id' => 5,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 562, 'user_id' => 5,'permission_id'=> 2,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 563, 'user_id' => 5,'permission_id'=> 3,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 571, 'user_id' => 5,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 572, 'user_id' => 5,'permission_id'=> 2,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 573, 'user_id' => 5,'permission_id'=> 3,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 581, 'user_id' => 5,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Operator 2 - Helpline, Hotline, Chat
            ['id' => 651, 'user_id' => 6,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 652, 'user_id' => 6,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 653, 'user_id' => 6,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 661, 'user_id' => 6,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 662, 'user_id' => 6,'permission_id'=> 2,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 663, 'user_id' => 6,'permission_id'=> 3,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 671, 'user_id' => 6,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 672, 'user_id' => 6,'permission_id'=> 2,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 673, 'user_id' => 6,'permission_id'=> 3,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 681, 'user_id' => 6,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 691, 'user_id' => 6,'permission_id'=> 1,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 692, 'user_id' => 6,'permission_id'=> 2,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 693, 'user_id' => 6,'permission_id'=> 3,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            // Operator 3 - Helpline, Hotline, Chat
            ['id' => 751, 'user_id' => 7,'permission_id'=> 1,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 752, 'user_id' => 7,'permission_id'=> 2,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 753, 'user_id' => 7,'permission_id'=> 3,'group_id' => 5,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 761, 'user_id' => 7,'permission_id'=> 1,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 762, 'user_id' => 7,'permission_id'=> 2,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 763, 'user_id' => 7,'permission_id'=> 3,'group_id' => 6,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 771, 'user_id' => 7,'permission_id'=> 1,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 772, 'user_id' => 7,'permission_id'=> 2,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 773, 'user_id' => 7,'permission_id'=> 3,'group_id' => 7,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 781, 'user_id' => 7,'permission_id'=> 1,'group_id' => 8,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 791, 'user_id' => 7,'permission_id'=> 1,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 792, 'user_id' => 7,'permission_id'=> 2,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 793, 'user_id' => 7,'permission_id'=> 3,'group_id' => 9,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            //for managerian pages
            ['id' => 794, 'user_id' => 2,'permission_id'=> 1,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 795, 'user_id' => 2,'permission_id'=> 2,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 796, 'user_id' => 2,'permission_id'=> 3,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 797, 'user_id' => 2,'permission_id'=> 4,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 798, 'user_id' => 4,'permission_id'=> 1,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 799, 'user_id' => 4,'permission_id'=> 2,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 800, 'user_id' => 4,'permission_id'=> 3,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 801, 'user_id' => 4,'permission_id'=> 4,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            //admin full permission
            ['id' => 802, 'user_id' => 1,'permission_id'=> 1,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 803, 'user_id' => 1,'permission_id'=> 2,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 804, 'user_id' => 1,'permission_id'=> 3,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 805, 'user_id' => 1,'permission_id'=> 4,'group_id' => 10,'created_at'=> new DateTime, 'updated_at' =>new DateTime],

        );
        DB::table('group_permissions')->insert($group_permissions);

        DB::table('resource_types')->delete();
        $resource_types = array(
            ['id' => 1 , 'name' => 'website', 'display_name_en' => 'Website', 'display_name_gr' => 'Ιστοσελίδα','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'chatroom', 'display_name_en' => 'Chat room', 'display_name_gr' => 'Chat room','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'mobile', 'display_name_en' => 'Mobile communication', 'display_name_gr' => 'Κινητή τηλεφωνία ','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4 , 'name' => 'social-media', 'display_name_en' => 'Social media', 'display_name_gr' => 'Κοινωνικά Δίκτυα','created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 5 , 'name' => 'irrelevant', 'display_name_en' => '_IRRELEVANT_', 'display_name_gr' => 'Δεν προκύπτει περιστατικό','created_at'=> new DateTime, 'updated_at' =>new DateTime],            
        );
        DB::table('resource_types')->insert($resource_types);

        DB::table('content_types')->delete();
        $content_types = array(
            ['id' => 1 , 'is_for' => 'helpline', 'name' => 'cyberbullying', 'display_name_en' => 'Cyberbullying', 'description_en'=> 'Bullying usually involves a child being picked on, ridiculed and intimidated by another child, other children or adults using online technologies. Bullying may involve psychological violence. Cyberbullying can be intentional and unintentional.','display_name_gr' => 'Διαδικτυακός / Ηλεκτρονικός Εκφοβισμός','description_gr'=> 'Ο Διαδικτυακός / Ηλεκτρονικός εκφοβισμός, αφορά στη χρήση του Διαδικτύου, των κινητών τηλεφώνων και άλλων ψηφιακών τεχνολογιών, προκειμένου να εκφρασθεί μία εσκεμμένη, επαναλαμβανόμενη και επιθετική συμπεριφορά, απέναντι σε ένα πρόσωπο ή σε μια ομάδα προσώπων, με σκοπό την πρόκληση συναισθηματικής και ψυχολογικής βλάβης.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 2 , 'is_for' => 'helpline', 'name' => 'excessive-use', 'display_name_en' => 'Excessive use','description_en'=> 'Calls related to the amount of time spent on media – related to the loss of control over internet or online use as compared to other (offline) activities.', 'display_name_gr' => 'Εθισμός στο Διαδίκτυο / Πολύωρη ενασχόληση με το Διαδίκτυο και τις ψηφιακές συσκευές','description_gr'=> 'Ο εθισμός στο Διαδίκτυο, αφορά στην πολύωρη και προβληματική χρήση του Διαδικτύου σε δραστηριότητες σχετικές µε το Διαδίκτυο (ηλεκτρονικά- διαδικτυακά παιχνίδια, διαδικτυακές συνομιλίες, σελίδες κοινωνικής δικτύωσης κ.λ.π.), η οποία μπορεί να επιφέρει σημαντικές επιπτώσεις στη ψυχολογική, κοινωνική και ακαδημαϊκή/μαθησιακή λειτουργικότητα του ατόμου','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 3 , 'is_for' => 'helpline', 'name' => 'love-relationships-sexuality', 'display_name_en' => 'Love / relationships / sexuality (online)','description_en'=> 'Questions relating to online love, relationships, dating sites etc.', 'display_name_gr' => 'Αγάπη / σχέσεις / σεξουαλικότητα (διαδικτυακά) ','description_gr'=> 'Ερωτήσεις σχετικά με την αγάπη και τις σχέσεις στο διαδίκτυο, τους ιστοχώρους για ραντεβού κ.λπ..','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 4 , 'is_for' => 'helpline', 'name' => 'sexting', 'display_name_en' => 'Sexting','description_en'=> 'The consensual or non-consensual sending or receiving of sexual images and/or texts via mobile and other devices (including appearing in such images) amongst peers.', 'display_name_gr' => 'Sexting','description_gr'=> 'Η συναινετική ή η μη συναινετική αποστολή ή λήψη σεξουαλικών μηνυμάτων, φωτογραφιών ή βίντεο µέσω διαδικτύου, µέσω κινητών ή και άλλων συσκευών. μεταξύ των συνομηλίκων.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 5 , 'is_for' => 'helpline', 'name' => 'sextortion', 'display_name_en' => 'Sextortion','description_en'=> 'Sextortion is a means of coercing cybercrime victims to perform sexual favours or to pay a hefty sum in exchange for the non-exposure of their explicit images, videos or conversations.', 'display_name_gr' => 'Sextortion','description_gr'=> 'Μορφή σεξουαλικής εκμετάλλευσης, κατά την οποία, σεξουαλικές πληροφορίες (π.χ., βίντεο, εικόνες, συνομιλίες) χρησιμοποιούνται ως μέσο εξαναγκασμού για σεξουαλική ή και οικονομική εκμετάλλευση των θυμάτων σε αντάλλαγμα για τη μη έκθεση/δημοσίευση των συγκεκριμένων εικόνων, βίντεο ή συνομιλιών τους','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 6 , 'is_for' => 'helpline', 'name' => 'sexual-harassment', 'display_name_en' => 'Sexual harassment','description_en'=> 'Unwanted sexual contact/content/comments - Including unsolicited contact.', 'display_name_gr' => 'Σεξουαλική παρενόχληση','description_gr'=> 'Αποστολή ανεπιθύμητου σεξουαλικού περιεχομένου σχολίων με σκοπό τη σεξουαλική επαφή εντός ή εκτός του διαδικτύου. Συμπεριλαμβανομένης και της ανεπιθύμητης επαφής','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 7 , 'is_for' => 'helpline', 'name' => 'grooming', 'display_name_en' => 'Grooming','description_en'=> "Actions deliberately undertaken (sometimes, but not always over a longer period of time) by an adult or stranger with the aim of befriending and establishing an emotional connection with a child, in order to lower the child's inhibitions in preparation for sexual activity with the child.", 'display_name_gr' => 'Διαδικτυακή αποπλάνηση','description_gr'=> 'Δραστηριότητες, οι οποίες πραγματοποιούνται σκόπιμα από έναν ενήλικα ή ξένο άτομο, με σκοπό τη φιλική επαφή και τη δημιουργία μιας συναισθηματικής σχέσης, προκειμένου να μειωθούν οι αναστολές/αντιστάσεις του ανήλικου ατόμου για την προετοιμασία της σεξουαλικής δραστηριότητας με σκοπό να τον/την συναντήσει, στον πραγματικό κόσμο και να τον/την αποπλανήσει/παρενοχλήσει σεξουαλικά.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 8 , 'is_for' => 'helpline', 'name' => 'e-crime', 'display_name_en' => 'E-crime','description_en'=> "Identity theft, fraud, data theft, copyright infringement, hacking, piracy, etc. This may include referrals to a hotline.", 'display_name_gr' => 'Ηλεκτρονικό έγκλημα','description_gr'=> 'Κλοπή ταυτότητας, απάτη (π.χ., οικονομική), κλοπή δεδομένων, παραβίαση πνευματικών δικαιωμάτων, παραβίαση προσωπικών δεδομένων (hacking), πειρατεία κ.λπ.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 9 , 'is_for' => 'helpline', 'name' => 'hate-speech', 'display_name_en' => 'Hate speech','description_en'=> "Discrimination or prejudice against others on account of their race, religion, ethnic origin, sexual orientation, disability or gender – this could include racist materials online or racist comments which have been made by a group or individual.", 'display_name_gr' => 'Εχθρικός λόγος','description_gr'=> 'Διακρίσεις ή προκαταλήψεις εναντίον άλλων λόγω της φυλής, της θρησκείας, της εθνικής καταγωγής, του σεξουαλικού προσανατολισμού, της αναπηρίας ή του φύλου - θα μπορούσαν να περιλαμβάνονται ρατσιστικό περιεχόμενο/υλικό στο διαδίκτυο ή ρατσιστικά σχόλια που έχουν γίνει από μια ομάδα ή ένα άτομο.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 10 , 'is_for' => 'helpline', 'name' => 'potentially-harmful-content', 'display_name_en' => 'Potentially harmful content','description_en'=> "Including terrorism, online prostitution, drugs, eating disorders, self-harm etc. Including calls related to sites promoting suicide and explaining ways to commit suicide. This may include referrals to a hotline.", 'display_name_gr' => 'Πιθανώς επιβλαβές περιεχόμενο','description_gr'=> 'Επιβλαβές περιεχόμενο συμπεριλαμβανομένης της τρομοκρατίας, της διαδικτυακής πορνείας, των ναρκωτικών, των διατροφικών διαταραχών, του αυτοτραυματισμού, ιστοτόπων προώθησης της αυτοκτονίας κ.λπ.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 11 , 'is_for' => 'helpline', 'name' => 'gaming', 'display_name_en' => 'Gaming','description_en'=> "For any issues related to gaming content, possible addiction etc.", 'display_name_gr' => 'Παιχνίδια','description_gr'=> 'Προβλήματα σχετικά με το περιεχόμενο τυχερού ή άλλου παιχνιδιού, τον πιθανό εθισμό σε διαδικτυακά και ηλεκτρονικά παιχνίδια κ.λπ.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 12 , 'is_for' => 'helpline', 'name' => 'online-reputation', 'display_name_en' => 'Online reputation','description_en'=> "Concerns about damage to reputation online (this may include requests for information on how to protect online reputation).", 'display_name_gr' => 'Διαδικτυακή φήμη','description_gr'=> 'Ανησυχίες για ζημιά στη φήμη στο διαδίκτυο (αυτό μπορεί να περιλαμβάνει αιτήματα για πληροφορίες σχετικά με τον τρόπο προστασίας της φήμης στο διαδίκτυο).','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 13 , 'is_for' => 'helpline', 'name' => 'technical-settings', 'display_name_en' => 'Technical settings','description_en'=> "Where a caller needs help to alter settings - Filtering & parental controls, Anti-virus, Spam, etc. Including security maintenance (for a device) (e.g. firewall, updates, popups, cookies).", 'display_name_gr' => 'Τεχνική υποστήριξη','description_gr'=> 'Βοήθεια για αλλαγή ρυθμίσεων, ανάκτηση κωδικών, φιλτράρισμα & γονικό έλεγχο, anti-virus, spam κ.λπ. Συμπεριλαμβανομένης της συντήρησης ασφαλείας (για μια συσκευή) (π.χ., Firewall, updates, popups, cookies)','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 14 , 'is_for' => 'helpline', 'name' => 'advertising', 'display_name_en' => 'Advertising / commercialism','description_en'=> "Chain emails, phishing sites, misleading policies, terms and conditions.", 'display_name_gr' => 'Διαφήμιση / εμπορευματοποίηση','description_gr'=> 'Αλυσιδωτά μηνύματα, phishing sites,  παραπλανητικές πολιτικές, όροι και προϋποθέσεις.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 15, 'is_for' => 'helpline', 'name' => 'media-literacy-education', 'display_name_en' => 'Media literacy / education','description_en' => "Callers asking for information relating to a better understanding of the internet, online services and how they can be used.", 'display_name_gr' => 'Ψηφιακός γραμματισμός / εκπαίδευση','description_gr'=> 'Πληροφορίες σχετικά με την καλύτερη κατανόηση του διαδικτύου, των ηλεκτρονικών υπηρεσιών και το τρόπο με τον οποίο μπορούν να τις χρησιμοποιήσουν.','created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 16, 'is_for' => 'helpline', 'name' => 'data-privacy', 'display_name_en' => 'Data privacy','description_en'=> "Issues related to the abuse of personal or private information, as well as how to protect privacy and how to react when something has gone wrong.", 'display_name_gr' => 'Ιδιωτικότητα','description_gr'=> 'Ζητήματα σχετικά με την κατάχρηση/παραβίαση προσωπικών ή ιδιωτικών πληροφοριών, καθώς, επίσης,  και τον τρόπο προστασίας της ιδιωτικότητας και τον τρόπο αντίδρασης σε περίπτωση που κάτι πάει στραβά.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 17, 'is_for' => 'helpline', 'name' => 'irrelevant', 'display_name_en' => '_IRRELEVANT_','description_en'=> "Irrelevant report.", 'display_name_gr' => 'Όχι σχετικό','description_gr'=> 'Δεν προκύπτει περιστατικό.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],


            ['id' => 21, 'is_for' => 'hotline', 'name' => 'child-pornography', 'display_name_en' => 'Child Pornography', 'description_en'=> "Child Pornography.", 'display_name_gr' => 'Παιδική πορνογραφία', 'description_gr' => 'Παιδική πορνογραφία.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 22, 'is_for' => 'hotline', 'name' => 'hacking', 'display_name_en' => 'Hacking','description_en'=> "Hacking.", 'display_name_gr' => 'Παραβίαση προσωπικών δεδομένων','description_gr'=> 'Παραβίαση προσωπικών δεδομένων.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 23, 'is_for' => 'hotline', 'name' => 'network-hijacking', 'display_name_en' => 'Network Hijacking','description_en'=> "Network Hijacking.", 'display_name_gr' => 'Παραβίαση του απορρήτου των επικοινωνιών','description_gr'=> 'Παραβίαση του απορρήτου των επικοινωνιών.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 24, 'is_for' => 'hotline', 'name' => 'cyber-fraud', 'display_name_en' => 'Cyber fraud','description_en'=> "Cyber fraud.", 'display_name_gr' => 'Διαδικτυακή απάτη','description_gr'=> 'Διαδικτυακή απάτη.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 25, 'is_for' => 'hotline', 'name' => 'hate-speech', 'display_name_en' => 'Hate speech','description_en'=> "Hate speech.", 'display_name_gr' => 'Μισαλλόδοξος λόγος (ρατσισμός / ξενοφοβία)','description_gr'=> 'Μισαλλόδοξος λόγος (ρατσισμός / ξενοφοβία).', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 26, 'is_for' => 'hotline', 'name' => 'other', 'display_name_en' => 'Other','description_en'=> "Other.", 'display_name_gr' => 'Άλλο','description_gr'=> 'Άλλο.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],

            ['id' => 27, 'is_for' => 'hotline', 'name' => 'irrelevant', 'display_name_en' => '_IRRELEVANT_', 'description_en'=> "Irrelevant report.", 'display_name_gr' => 'Όχι σχετικό','description_gr'=> 'Δεν προκύπτει περιστατικό.', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            
        );
        DB::table('content_types')->insert($content_types);

        DB::table('status')->delete();
        $status = array(
            ['id' => 1 , 'name' => 'New', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'Opened', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'Closed', 'created_at'=> new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('status')->insert($status);

        DB::table('chatrooms')->delete();
        $chatroom = array(
            ['id' => 1 , 'chat_id' => 1,'status' => 0,'receiver'=> 0, 'sender' =>0, 'created_at'=> new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('chatrooms')->insert($chatroom);

        DB::table('references_by')->delete();
        $references_by = array(
            ['id' => 1 , 'name' => 'none','display_name_gr' => 'Κανένας', 'display_name_en' =>'No one','description_gr'=> 'Κανένας','description_en' =>'No one', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'cyber-crime-unit','display_name_gr' => 'Δίωξη Ηλεκτρονικού Εγκλήματος', 'display_name_en' =>'Cyber Crime Unit','description_gr'=> 'Δίωξη Ηλεκτρονικού Εγκλήματος','description_en' =>'Cyber Crime Unit', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'school','display_name_gr' => 'Σχολείο / Εκπαιδευτήριο', 'display_name_en' =>'School','description_gr'=> 'Σχολείο / Εκπαιδευτήριο', 'description_en' =>'School' ,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4 , 'name' => 'professional','display_name_gr' => 'Επαγγελματία (εκπαιδευτικός, ψυχολόγος, κοινωνικός λειτουργός)', 'display_name_en' =>'Profesional','description_gr'=> 'Επαγγελματία (εκπαιδευτικός, ψυχολόγος, κοινωνικός λειτουργός)', 'description_en' =>'Profesional' ,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('references_by')->insert($references_by);

        DB::table('references_to')->delete();
        $references_to = array(
            ['id' => 1 , 'name' => 'none','display_name_gr' => 'Κανένας', 'display_name_en' =>'No one','description_gr'=> 'Κανένας','description_en' =>'No one', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'cyber-crime-unit','display_name_gr' => 'Δίωξη Ηλεκτρονικού Εγκλήματος', 'display_name_en' =>'Cyber Crime Unit','description_gr'=> 'Δίωξη Ηλεκτρονικού Εγκλήματος','description_en' =>'Cyber Crime Unit', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'hotline','display_name_gr' => 'Γραμμή Καταγγελιών HotLine – 1480', 'display_name_en' =>'Hotline','description_gr'=> 'Γραμμή Καταγγελιών HotLine – 1480', 'description_en' =>'Hotline' ,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4 , 'name' => 'professional','display_name_gr' => 'Επαγγελματία (εκπαιδευτικός, ψυχολόγος, κοινωνικός λειτουργός)', 'display_name_en' =>'Profesional','description_gr'=> 'Επαγγελματία (εκπαιδευτικός, ψυχολόγος, κοινωνικός λειτουργός)', 'description_en' =>'Profesional' ,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
            ['id' => 5 , 'name' => 'facebook','display_name_gr' => 'Policy Casework – Facebook', 'display_name_en' =>'Policy Casework – Facebook','description_gr'=> 'Policy Casework – Facebook', 'description_en' =>'Policy Casework – Facebook' ,'created_at'=> new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('references_to')->insert($references_to);

        DB::table('action_taken')->delete();
        $action_taken = array(
            ['id' => 1 , 'name' => 'Junk', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('action_taken')->insert($action_taken);

        DB::table('submission_types')->delete();
        $submission_types = array(
            ['id' => 1 , 'name' => 'phone-call', 'display_name_en' => 'Phone call', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'email', 'display_name_en' => 'Email', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'electronic-form', 'display_name_en' => 'Electronic form', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4 , 'name' => 'online-chat', 'display_name_en' => 'Online chat', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('submission_types')->insert($submission_types);

        DB::table('priorities')->delete();
        $priorities = array(
            ['id' => 1 , 'name' => 'normal', 'color' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'important', 'color' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'critical', 'color' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('priorities')->insert($priorities);

        DB::table('report_roles')->delete();
        $report_roles = array(
            ['id' => 1 , 'name' => 'male-respondent', 'display_name_en' => 'Male respondent', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'female-respondent', 'display_name_en' => 'Female respondent', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => 'children', 'display_name_en' => 'Children (age 5-11)', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 4 , 'name' => 'adolescent', 'display_name_en' => 'Adolescent (age 12-18)', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 5 , 'name' => 'parent', 'display_name_en' => 'Parent', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 6 , 'name' => 'teacher', 'display_name_en' => 'Teacher', 'display_name_gr' => '', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('report_roles')->insert($report_roles);

        DB::table('age_groups')->delete();
        $age_groups = array(
            ['id' => 1 , 'name' => '5-11', 'display_name_gr' => '5-11 ετών', 'display_name_en' => '5-11 years', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => '12-18', 'display_name_gr' => '12-18 ετών', 'display_name_en' => '12-18 years', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 3 , 'name' => '18+', 'display_name_gr' => '18+ ετών', 'display_name_en' => '18+ years', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('age_groups')->insert($age_groups);

        DB::table('gender')->delete();
        $gender = array(
            ['id' => 1 , 'name' => 'male', 'display_name_gr' => 'Άρρεν', 'display_name_en' => 'Male', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
            ['id' => 2 , 'name' => 'female', 'display_name_gr' => 'Θήλυ', 'display_name_en' => 'Female', 'created_at' => new DateTime, 'updated_at' =>new DateTime],
        );
        DB::table('gender')->insert($gender);
    }
}
