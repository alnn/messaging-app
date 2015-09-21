<?php

class Patch implements App_Patch_Interface {
    
    public function run()
    {
        
        App::debug(['Drop table user']);
        
        App_Db::write('DROP TABLE IF EXISTS `user`');
        
        App::debug(['Creating table user']);
        
        App_Db::write('CREATE TABLE `user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `login` varchar(50) NOT NULL DEFAULT \'\',
            `first_name` varchar(100) NOT NULL DEFAULT \'\',
            `last_name` varchar(100) NOT NULL DEFAULT \'\',
            `admin` TINYINT(1) NOT NULL DEFAULT 0,
            `ban` TINYINT(1) NOT NULL DEFAULT 0,
            `password` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8');
        
        App::debug(["Add users"]);
        
        App_Db::write(
            'INSERT INTO `user` VALUES 
            (
                1,
                "admin",
                "John",
                "Doe",
                1,
                0,
                "admin"
            ),
            (
                2,
                "james_g",
                "James",
                "Grisham",
                0,
                0,
                "john_g"
            ),
            (
                3,
                "robin_c",
                "Robin",
                "Cook",
                0,
                1,
                "robin_c"
            )'
        );

        
        App::debug(['Drop table message']);
        
        App_Db::write('DROP TABLE IF EXISTS `message`');

        App::debug(['Creating table message']);
        
        App_Db::write('
            CREATE TABLE `message` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `sender_id` int(11) NOT NULL,
                `recipient_id` int(11) NOT NULL,
                `unread` TINYINT(1) NOT NULL DEFAULT 1,
                `message` text NOT NULL,
                `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                KEY `i_sender_id` (`sender_id`),
                KEY `i_recipient_id` (`recipient_id`),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8');
        
        App::debug(["Add messages"]);
        
        App_Db::write(
            'INSERT INTO `message` VALUES 
            (
                1,
                1,
                2,
                1,
                "Test message 1",
                CURRENT_TIMESTAMP
            ),
            (
                2,
                2,
                1,
                1,
                "Test message 2",
                CURRENT_TIMESTAMP
            ),
            (
                3,
                1,
                2,
                1,
                "Test message 3",
                CURRENT_TIMESTAMP
            )'
        );
        
    }
    
}
