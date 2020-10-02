CREATE database polaznik21 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use polaznik21;

CREATE TABLE IF NOT EXISTS address
(
    id           int          not null primary key auto_increment,
    city_name    varchar(255) not null,
    postal_code  int          not null,
    address      varchar(255) not null
);

CREATE TABLE IF NOT EXISTS shop
(
    id         int not null primary key auto_increment,
    address_id int not null,
    foreign key (address_id) references address (id)
);

CREATE TABLE IF NOT EXISTS role
(
    id   int          not null primary key auto_increment,
    name varchar(255) default 'customer'
);

CREATE TABLE IF NOT EXISTS `user` (
                                      id         int                 not null primary key auto_increment,
                                      email      varchar(255) UNIQUE not null,
                                      username varchar(255) UNIQUE not null,
                                      first_name varchar(255)        not null,
                                      last_name  varchar(255)        not null,
                                      password   varchar(255)        not null,
                                      address_id int                 not null,
                                      role_id    int                 not null,
                                      foreign key (address_id) references address (id)
                                          on delete cascade,
                                      foreign key (role_id) references role (id)
                                          on delete cascade
);

CREATE TABLE IF NOT EXISTS category
(
    id                       int          not null primary key auto_increment,
    category_name varchar(255) not null
);

CREATE TABLE IF NOT EXISTS product
(
    id                  int          not null primary key auto_increment,
    product_name        varchar(255) not null,
    product_price       double       not null,
    product_description varchar(255) not null,
    product_picture blob not null,
    product_active tinyint not null default 1

);

CREATE TABLE IF NOT EXISTS product_category
(
    category_id int not null ,
    product_id int not null,
    foreign key (category_id) references category(id)
        on delete cascade,
    foreign key (product_id) references product(id)
        on delete cascade,
    PRIMARY KEY (category_id, product_id)

);

CREATE TABLE IF NOT EXISTS `order`
(
    id         int not null primary key auto_increment,
    user_id    int not null,
    order_date datetime not null default now(),
    foreign key (user_id) references user (id)
        on delete cascade
);

CREATE TABLE IF NOT EXISTS order_product
(
    id         int not null primary key auto_increment,
    order_id   int not null,
    product_id int not null,
    quantity   int not null,
    foreign key (order_id) references `order` (id)
        on delete cascade,
    foreign key (product_id) references product (id)
        on delete cascade
);
